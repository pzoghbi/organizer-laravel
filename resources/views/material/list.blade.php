@extends('layouts.app')
@section('content')
    @include('layouts.flash')
    <div class="row justify-content-center">
        <h1 class="h1">{{ auth()->user()->subjects()->where('id', request()->route('subject_id'))->firstOrFail()->name }}</h1>
        <h5 class="h5">Materijali</h5>
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
