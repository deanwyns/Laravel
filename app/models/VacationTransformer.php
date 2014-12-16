<?php
class VacationTransformer extends League\Fractal\TransformerAbstract {

    public function transform(Vacation $vacation) {
        $currentParticipants = $vacation->registrations->count();
        $likes = $vacation->likes->count();
        $categoryPhoto = URL::route('category.photo', ['category' => $vacation->category_id]);

        return [
            'id' => $vacation->id,
            'title' => $vacation->title,
            'description' => $vacation->description,
            'promo_text' => $vacation->promo_text,
            'location' => $vacation->location,
            'age_from' => $vacation->age_from,
            'age_to' => $vacation->age_to,
            'transportation' => $vacation->transportation,
            'max_participants' => $vacation->max_participants,
            'base_cost' => $vacation->base_cost,
            'one_bm_member_cost' => $vacation->one_bm_member_cost,
            'two_bm_member_cost' => $vacation->two_bm_member_cost,
            'tax_deductable' => $vacation->tax_deductable,
            'begin_date' => $vacation->begin_date,
            'end_date' => $vacation->end_date,
            'likes' => $likes,
            'picasa_album_id' => $vacation->picasa_album_id,
            'category_id' => $vacation->category_id,
            'category_photo' => $categoryPhoto
        ];
    }
}