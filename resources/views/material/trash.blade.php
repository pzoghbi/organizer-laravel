@extends('layouts.app')
@section('content')
    @include('layouts.flash')
    <div class="row justify-content-center">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="h5">Materijali</h5>
            <a href="{{ route('material.emptyTrash') }}" class="btn btn-danger text-white">Empty trash</a>
        </div>
        <div class="row row-cols-lg-6 row-cols-md-4 row-cols-sm-2">
        @foreach(auth()->user()->trashedMaterials() as $material)
            <div class="col mb-3">
                <div class="card h-100 border shadow">
                    <a class="card-body d-flex justify-content-center">
                        <div class="align-self-center text-center fs-5">{{ $material->name }}</div>
                    </a>
                    <form action="{{ route('material.restore', $material) }}" method="POST">
                        @csrf
                        <button class="btn btn-success w-100" type="submit">Restore</button>
                    </form>
                    <form action="{{ route('material.destroy', $material->id) }}" method="POST">
                        @csrf
                        @method("DELETE")
                        <button class="btn btn-danger text-white w-100" type="submit">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
        </div>
    </div>
@endsection
