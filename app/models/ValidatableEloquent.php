<?php

/**
 * Deze klasse gebruiken we om op een elegante manier de
 * validatie van Models te implementeren.
 *
 * Een Model die deze klasse erft, kan de variabele
 * $rules definiëren. Er kan dan $model->validate($input_data)
 * aangeroepen worden.
 *
 * Deze method returnt true wanneer de validatie geslaagd is.
 * Anders returnt de method false en kan de getter errors()
 * gebruikt worden om de foutmeldingen te verkrijgen.
 */
class ValidatableEloquent extends Eloquent {
    /**
     * Validation rules
     * @var array
     */
    protected $rules = [];

    /**
     * Contains the error messages when validation
     * fails
     * @var array of strings
     */
    protected $errors;

    /**
     * Validates the model against the defined
     * rules
     * @param  array $data of input data
     * @return boolean       true when valid
     */
    public function validate($data, $sometimes = false, $id = '') {
        $tmpRules = $this->rules;
        if(!empty($id) || $sometimes) {
            foreach($this->rules as $key => $value) {
                if(!empty($id) && strpos($value, '{ID}') !== false) {
                    $tmpRules[$key] = str_replace('{ID}', $id, $value);
                }
                
                if($sometimes) {
                    $tmpRules[$key] = $tmpRules[$key] . '|sometimes';
                }
            }
        }

        $v = Validator::make($data, $tmpRules);

        if ($v->fails()) {
            $this->errors = $v->messages();
            return false;
        }

        return true;
    }

    /**
     * Getter for the error messages
     * @return array of strings
     */
    public function errors() {
        return $this->errors;
    }

    /**
     * Overrides update function to first check if
     * a password is given, 
     * @param  array $attributes
     * @return bool|int
     */
    public function update(array $attributes = []) {
        if(array_key_exists('password', $attributes))
            $attributes['password'] = Hash::make($attributes['password'], ['rounds' => 12]);

        return parent::update($attributes);
    }
}