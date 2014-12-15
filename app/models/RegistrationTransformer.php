<?php
class RegistrationTransformer extends League\Fractal\TransformerAbstract {

    public function transform(Registration $registration) {
        return [
            'id' => $registration->id,
            'is_paid' => $registration->is_paid,
            'child_id' => $registration->child_id,
            'child_first_name' => $registration->child->first_name,
            'child_last_name' => $registration->child->last_name,
            'vacation_id' => $registration->vacation_id,
            'vacation_title' => $registration->vacation->title,
            'facturation_first_name' => $registration->facturation_first_name,
            'facturation_last_name' => $registration->facturation_last_name,
            'facturation_address' => $registration->address
        ];
    }
}