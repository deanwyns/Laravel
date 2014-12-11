<?php
class CategoryTransformer extends League\Fractal\TransformerAbstract {

    public function transform(Category $category) {
        $categoryPhoto = URL::route('category.photo', ['category' => $category->id]);

    	return [
            'name' => $category->name,
            'photo' => $categoryPhoto
        ];
    }
}