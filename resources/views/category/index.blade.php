@extends('layouts.app')
@section('content')
    <div class="row">
        <label class="form-label">Categories</label>
        <div class="form-group mb-3">
            <div class="btn-group d-inline-block mb-3">
                @foreach(auth()->user()->categories as $category)
                    <a type="checkbox" class="btn btn-primary text-white mb-1" href="{{ route('category.edit', $category) }}"
                       id="material-category-{{ $category->id }}">{{ $category->name }}</a>
                @endforeach
            </div>
            <div class="input-group w-50">
                <input type="text" class="form-control" name="name" id="category-name"
                       form="category_store" placeholder="Add a new category">
                <input type="submit" class="btn btn-secondary" value="Add" form="category_store">
            </div>
        </div>
    </div>
@endsection
