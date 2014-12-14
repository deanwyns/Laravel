<?php
class VacationTransformer extends League\Fractal\TransformerAbstract {

    public function transform(Vacation $vacation) {
        $currentParticipants = $vacation->registrations()->count();
        $likes = $vacation->likes()->count();
        $categoryPhoto = URL::route('category.photo', ['category' => $vacation->category_id]);

        return [
            'id' => $vacation->id,
            'title' => $vacation->title,
            'description' => $vacation->description,
            'promoText' => $vacation->promoText,
            'location' => $vacation->location,
            'ageFrom' => $vacation->ageFrom,
            'ageTo' => $vacation->ageTo,
            'transportation' => $vacation->transportation,
            'maxParticipants' => $vacation->maxParticipants,
            'currentParticipants' => $currentParticipants,
            'baseCost' => $vacation->baseCost,
            'oneBmMemberCost' => $vacation->oneBmMemberCost,
            'twoBmMemberCost' => $vacation->twoBmMemberCost,
            'taxDeductable' => $vacation->taxDeductable,
            'beginDate' => $vacation->beginDate,
            'endDate' => $vacation->endDate,
            'likes' => sizeof($likes),
            'picasa_album_id' => $vacation->picasa_album_id,
            'category_id' => $vacation->category_id,
            'category_photo' => $categoryPhoto
        ];
    }
}