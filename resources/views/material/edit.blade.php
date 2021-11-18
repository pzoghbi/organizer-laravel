@extends('layouts.app')
@section('content')
    @include('layouts.errors')

    <div class="row d-flex mx-auto" style="width: 50rem;">
        <h2 class="h2 mb-3">Edit the material: {{ $material->name }}</h2>
        <form action="{{ route('material.update', $material) }}" enctype="multipart/form-data" id="material_store"
              method="POST">
            @csrf
            @method('PATCH')
        </form>
        <form action="{{ route('category.store') }}" id="category_store" method="POST">@csrf</form>

        <div class="form-group mb-3">
            <!-- Predmet, kategorija, detalji, file -->
            <div class="input-group mb-1">
                <label class="input-group-text" for="material-file-name">File</label>
                <input class="form-control bg-light" form="material_store" id="material-file-name" name="file-name"
                    type="text" value="{{ old('file-name') ?? $material->name }}">
            </div>
            <small class="alert-info ms-auto rounded-pill px-1">You can change the name of the material.</small>
        </div>

        <div class="form-group mb-3">
            <label class="form-label" for="material-details">Details</label>
            <textarea class="form-control" cols="30" form="material_store"
                id="material-details" name="details" placeholder="Add any details (optional)"
                rows="10">{{ $material->details }}</textarea>
        </div>

        <div class="input-group mb-3">
            <label class="input-group-text" for="material-subject">Subject</label>
            <select class="form-select" form="material_store" id="material-subject" name="subject_id">
                <option disabled selected value="">Choose a subject</option>
                @foreach(auth()->user()->subjects as $subject)
                    <option value="{{ $subject->id }}"
                        {{ $material->subject_id === $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <label class="form-label">Categories</label>
        <div class="form-group mb-3">
            <div class="btn-group d-inline-block">
                @foreach(auth()->user()->categories as $category)
                    <input type="checkbox" class="btn-check" name="categories[]" form="material_store"
                        id="material-category-{{ $category->id }}" value="{{ $category->id }}"
                        {{ in_array($category->id, $material->categories()->pluck('id')->toArray()) ? 'checked' : ''}}>
                    <label for="material-category-{{ $category->id }}"
                           class="btn btn-outline-secondary me-1 mb-3">{{ $category->name }}</label>
                @endforeach
            </div>
            <div class="input-group w-50">
                <input type="text" class="form-control" name="category-new" id="material-category-new"
                       form="category_store" placeholder="Add a new category">
                <button type="submit" class="btn btn-outline-secondary">Add</button>
            </div>
        </div>

        <div class="input-group mb-3">
            <button class="btn btn-success ms-auto text-white" form="material_store" type="submit">Update</button>
        </div>
    </div>
@endsection
