@extends('layouts.app')
@section('content')
    <form action="{{ route('material.destroy', $material) }}">
        <h2 class="h2">
            Are you sure you want to delete <span
                class="text-danger text-decoration-underline">{{ $material->name }}</span>?
        </h2>
        <button class="btn btn-outline-danger" type="submit">Delete</button>
    </form>
@endsection
