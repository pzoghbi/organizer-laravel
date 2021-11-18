<?php


namespace App\Services;


use App\Models\Category;

class CategoryService
{
    public function store($data)
    {
        $category = new Category();
        $category->name = $data['name'];
        $category->user_id = auth()->id();
        return $category->save();
    }

    public function update($category, $data)
    {
        $this->authorize($category->id);
        $category->name = $data['name'];
        $category->save();
    }

    public function destroy($category_id)
    {
        $this->authorize($category_id);
        return Category::destroy($category_id);
    }

    public function authorize($category_id, $message = null)
    {
        $categories = Category::where('user_id', auth()->id())->pluck('id')->toArray();
        abort_unless(in_array($category_id, $categories), 403, $message);
    }
}
