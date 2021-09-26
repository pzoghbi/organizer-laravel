@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <h1 class="h1">Materijali</h1>
        <h2 class="h2">{{ $subject->name }}</h2>
        <div class="row row-cols-lg-6 row-cols-md-4 row-cols-sm-2">
        @foreach($materials as $material)
            <div class="col mb-3">
                <div class="card h-100 border shadow" style="">
                    <a class="card-body d-flex justify-content-center" href="{{ route('material.show', $material) }}">
                        <div class="align-self-center text-center fs-5">{{ $material->name }}</div>
                    </a>
                </div>
            </div>
        @endforeach
        </div>
    </div>
@endsection
