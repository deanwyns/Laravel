<?php
class UserTransformer extends League\Fractal\TransformerAbstract {

    public function transform(User $user) {
    	$subUser = $user->userable;
    	$subUserClass = strtolower(get_class($subUser));
    	$subUserAttributes = [];
    	switch($subUserClass) {
    		case 'parents':
    			$subUserAttributes = [
    				'first_name_mother' => $subUser->first_name_mother,
    				'last_name_mother' => $subUser->last_name_mother,
    				'nrn_mother' => $subUser->nrn_mother,
    				'first_name_father' => $subUser->first_name_father,
    				'last_name_father' => $subUser->last_name_father,
    				'nrn_father' => $subUser->nrn_father,
    				'phone_number' => $subUser->phone_number,
                    'children' => $subUser->children
    			];
    			break;

    		case 'monitor':

    			break;

    		case 'admin':

    			break;
    	}

    	$userAttributes = [
	        'id' => (int) $user->id,
	        'email' => $user->email,
	        'type' => $subUserClass
    	];

    	return array_merge($userAttributes, $subUserAttributes);
    }
}