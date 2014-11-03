<?php

use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
    /**
     * Laravel $code is always 500
     * message format:
     * SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it.
     * SQLSTATE[HY000] [1049] Unknown database 'blah'
     */
    App::error(function(\PDOException $e, $code) {
        Log::error('FATAL DATABASE ERROR: ' . $code . ' = ' . $e->getMessage());

        if (App::Environment('local')) {
            $message = explode(' ', $e->getMessage());
            $dbCode = rtrim($message[1], ']');
            $dbCode = trim($dbCode, '[');

            // codes specific to MySQL
            switch ($dbCode) {
                case 1049:
                    $userMessage = 'Unknown database - probably config error:';
                    break;
                case 2002:
                    $userMessage = 'DATABASE IS DOWN:';
                    break;
                default:
                    $userMessage = 'Untrapped Error:';
                    break;
            }

            $userMessage = $userMessage . ' - ' . $e->getMessage();

        } else {
            $userMessage = 'Onbekende fout';
        }

        return Response::json([ "message" => $userMessage, "status_code" => $code ], $code);

    });
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});

Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|--------------------------------------------------------------------------
| SSL Filter
|--------------------------------------------------------------------------
|
| The SSL filter is responsible for forcing the request to be secure (SSL).
| If it's not, the user is redirected to the secure equivalent.
|
*/

Route::filter('force.ssl', function()
{
    if(!Request::secure()) {
        return Redirect::secure(Request::path());
    }

});