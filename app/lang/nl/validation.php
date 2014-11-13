<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "':attribute' moet geaccepteerd worden.",
	"active_url"           => "':attribute' is geen geldige url.",
	"after"                => "':attribute' moet na :date zijn.",
	"alpha"                => "':attribute' mag enkel letters bevatten.",
	"alpha_dash"           => "':attribute' mag enkel letters, nummers of streepjes bevatten.",
	"alpha_num"            => "':attribute' mag enkel letters en nummers bevatten.",
	"array"                => "':attribute' moet een reeks zijn.",
	"before"               => "':attribute' moet voor :date zijn.",
	"between"              => array(
		"numeric" => "':attribute' moet tussen :min en :max liggen.",
		"file"    => "':attribute' moet tussen :min en :max kilobytes groot zijn.",
		"string"  => "':attribute' moet tussen :min en :max tekens hebben.",
		"array"   => "':attribute' moet tussen :min en :max items hebben.",
	),
	"confirmed"            => "':attribute' bevestiging komt niet overeen.",
	"date"                 => "':attribute' is geen geldige datum.",
	"date_format"          => "':attribute' komt niet overeen met het formaat :format.",
	"different"            => "':attribute' en ':other' moeten verschillen van elkaar.",
	"digits"               => "':attribute' moet :digits cijfers hebben.",
	"digits_between"       => "':attribute' moet tussen :min en :max cijfers hebben.",
	"email"                => "':attribute' moet een geldig e-mailadres zijn.",
	"exists"               => "Geselecteerde ':attribute' is ongeldig.",
	"image"                => "':attribute' moet een afbeelding zijn.",
	"in"                   => "Geselecteerde ':attribute' is ongeldig.",
	"integer"              => "':attribute' moet een geheel getal zijn.",
	"ip"                   => "':attribute' moet een geldig ip-adres zijn.",
	"max"                  => array(
		"numeric" => "':attribute' mag niet groter zijn dan :max.",
		"file"    => "':attribute' mag niet groter zijn dan :max kilobytes.",
		"string"  => "':attribute' mag niet langer zijn dan :max tekens.",
		"array"   => "':attribute' mag niet meer dan :max items bevatten.",
	),
	"mimes"                => "':attribute' moet één van de volgende bestandstypes zijn: :values.",
	"min"                  => array(
		"numeric" => "':attribute' moet groter zijn dan :min.",
		"file"    => "':attribute' moet groter zijn dan :min kilobytes.",
		"string"  => "':attribute' moet langer zijn dan :min tekens.",
		"array"   => "':attribute' moet meer dan :min items bevatten.",
	),
	"not_in"               => "Geselecteerde ':attribute' is ongeldig.",
	"numeric"              => "':attribute' moet een nummer zijn.",
	"regex"                => "Het formaat van ':attribute' is ongeldig.",
	"required"             => "Het ':attribute'-veld is verplicht.",
	"required_if"          => "':attribute' is verplicht als ':other' :value is.",
	"required_with"        => "':attribute' is verplicht als :values ingevuld is.",
	"required_with_all"    => "':attribute' is verplicht als :values ingevuld is.",
	"required_without"     => "':attribute' is verplicht als :values niet ingevuld is.",
	"required_without_all" => "':attribute' is verplicht als geen enkele van :values ingevuld zijn.",
	"same"                 => "':attribute' en ':other' moeten gelijk zijn.",
	"size"                 => array(
		"numeric" => "':attribute' moet :size zijn.",
		"file"    => "':attribute' moet :size kilobytes zijn.",
		"string"  => "':attribute' moet :size tekens hebben.",
		"array"   => "':attribute' moet :size items bevatten.",
	),
	"unique"               => "':attribute' bestaat al.",
	"url"                  => "Het formaat van ':attribute' is ongeldig.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(
		'email' => 'E-mailadres',
		'password' => 'Wachtwoord',
		'password_confirmed' => 'Wachtwoord bevestiging',
		'first_name_mother' => 'Voornaam van de moeder',
		'last_name_mother' => 'Naam van de moeder',
		'nrn_mother' => 'Rijksregisternummer van de vader',
		'first_name_father' => 'Voornaam van de vader',
		'last_name_father' => 'Naam van de vader',
		'nrn_father' => 'Rijksregisternummer van de vader',
		'phone_number' => 'Telefoonnummer',
		'title' => 'Titel',
		'promoText' => 'Promotietekst',
		'location' => 'Locatie',
		'ageFrom' => 'Leeftijd vanaf',
		'ageTo' => 'Leeftijd tot',
		'transportation' => 'Vervoer',
		'maxParticipants' => 'Maximaal aantal deelnemers',
		'baseCost' => 'Basisprijs',
		'oneBmMemberCost' => 'Prijs als één ouder Bond Moyson-lid is',
		'twoBmMemberCost' => 'Prijs als beide ouders Bond Moyson-lid zijn',
		'taxDeductable' => 'BTW-aftrekbaar',
		'beginDate' => 'Begindatum',
		'endDate' => 'Einddatum',
	),

);
