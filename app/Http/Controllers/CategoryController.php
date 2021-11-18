<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return View('category.index');
    }

    public function create()
    {
        //
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->store($request->validated());
        return redirect()->back();
    }

    public function show(Category $category)
    {
        // todo show materials with this category
    }

    public function edit(Category $category)
    {
        $this->categoryService->authorize($category->id);
        return View('category.edit')->with('category', $category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->categoryService->update($category, $request->validated());
        return View('category.index');
    }

    public function destroy(Category $category)
    {
        $this->categoryService->destroy($category->id);
        return redirect()->back();
    }
}
