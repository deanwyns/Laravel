<?php
class CategoryTransformer extends League\Fractal\TransformerAbstract {

    public function transform(Category $category) {
        $categoryPhoto = URL::route('category.photo', ['category' => $category->id]);

    	return [
    		'id' => $category->id,
            'name' => $category->name,
            'photo' => $categoryPhoto
        ];
    }
}