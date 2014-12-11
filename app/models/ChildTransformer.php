<?php
class ChildTransformer extends League\Fractal\TransformerAbstract {

    public function transform(Child $child) {
    	return [
            'first_name' => $child->first_name,
            'last_name' => $child->last_name,
            'address' => $child->address,
            'nrn' => $child->nrn,
            'date_of_birth' => $child->date_of_birth,
            'registrations' => $child->registrations
        ];
    }
}