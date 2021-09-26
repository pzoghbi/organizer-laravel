@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="hstack gap-2 mb-3">
            <h4 class="h4 d-inline-block">{{ $material->name }}</h4>
            <a class="btn btn-warning ms-auto" href="{{ route('material.edit', $material) }}">Edit</a>
            <a class="btn btn-danger text-white" href="{{ route('material.delete', $material) }}">Delete</a>
        </div>
    </div>

    <div class="ratio ratio-21x9 mb-3">
        <iframe allowfullscreen class="rounded-3" src="{{ asset('storage/'. $material->path) }}"></iframe>
    </div>

    <div class="row">
        <p>{{ $material->details }}</p>
    </div>
@endsection
