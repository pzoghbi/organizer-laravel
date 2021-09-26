@extends('layouts.app')
@section('content')
    <!-- Show subjects -->
    <div class="row">
        <a class="btn btn-success shadow mb-3 w-auto" href="{{ route('material.create') }}">New material</a>
    </div>

    <div class="row">
        <div class="card-deck px-0">
            @foreach($subjects as $subject)
                <div class="card mb-3" style="width: 18rem;">
                    <a class="card-header text-decoration-none" href="{{ route('material.subject', $subject->id) }}">
                        {{ $subject->name }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
