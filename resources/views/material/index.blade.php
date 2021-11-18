@extends('layouts.app')
@section('content')
    <!-- Show subjects -->
    <div class="d-flex mb-3">
        <a class="btn btn-success shadow" href="{{ route('material.create') }}">New material</a>
        <a href="{{ route('material.trash') }}" class="btn btn-danger text-white ms-auto">Trash</a>
    </div>

    <div class="row">
        <div class="card-deck px-0">
            @foreach($subjects as $subject)
                <div class="card mb-3" style="width: 18rem;">
                    <a class="card-header text-decoration-none" href="{{ route('material.list', $subject->id) }}">
                        {{ $subject->name }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
