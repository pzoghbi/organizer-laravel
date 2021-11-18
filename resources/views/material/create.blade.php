@extends('layouts.app')
@section('content')
    @include('layouts.errors')
    <div class="row d-flex mx-auto" style="width: 50rem;">
        <h2 class="h2 mb-3">Create a new study material</h2>
        <form action="{{ route('material.store') }}" method="POST" id="material_store" enctype="multipart/form-data">@csrf</form>
        <form action="{{ route('category.store') }}" method="POST" id="category_store">@csrf</form>

        <div class="form-group">
            <!-- Predmet, kategorija, detalji, file -->
            <!-- Name (optional) -->
            <div class="input-group mb-3">
                <input type="file" name="file" id="material-file" class="form-control" form="material_store"
                       required value="{{ old('file') }}">
            </div>

            <div class="form-group mb-3">
                <label for="material-details" class="form-label">Details</label>
                <textarea name="details" id="material-details" placeholder="Add any details (optional)"
                          class="form-control" cols="30" rows="10" form="material_store">{{ old('details') }}</textarea>
            </div>

            <div class="input-group mb-3">
                <label for="material-subject" class="input-group-text">Subject</label>
                <select name="subject_id" id="material-subject" class="form-select" form="material_store">
                    <option value="" disabled selected>Choose a subject</option>
                    @foreach(auth()->user()->subjects as $subject)
                        <option value="{{ $subject->id }}"
                            {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <label class="form-label">Categories</label>
            <div class="form-group mb-3">
                <div class="btn-group d-inline-block">
                    @foreach(auth()->user()->categories as $category)
                        <input type="checkbox" class="btn-check" name="categories[]" form="material_store"
                               id="material-category-{{ $category->id }}" value="{{ $category->id }}">
                        <label for="material-category-{{ $category->id }}"
                               class="btn btn-outline-secondary me-1 mb-3">{{ $category->name }}</label>
                    @endforeach
                </div>
                <div class="input-group w-50">
                    <input type="text" class="form-control" name="name" id="category-name"
                           form="category_store" placeholder="Add a new category">
                    <input type="submit" class="btn btn-outline-secondary" value="Add" form="category_store">
                </div>
            </div>

            <div class="input-group mb-3">
                <button class="btn btn-primary ms-auto text-white" form="material_store" type="submit">Create</button>
            </div>
        </div>
    </div>
@endsection
