@extends('layouts.app')
@section('content')
    <div class="d-flex mb-3">
        <h2 class=" mb-0">Your subjects</h2>
        <a href="{{ route('subject.create') }}" class="btn btn-success ms-auto h-100 text-white">New subject</a>
    </div>
    @foreach(auth()->user()->subjects as $subject)
        <div class="d-flex mb-3 card-header rounded shadow-sm">
            <div class="align-self-center">{{ $subject->name }}</div>
            <div class="ms-auto d-flex">
                <input class="form-control-color align-self-center me-2" type="color" name="color" readonly
                       id="subject-color" value="{{ $subject->color }}" disabled>

                <a class="btn btn-warning align-self-center me-2" href="{{ route('subject.edit', $subject->id) }}">Edit</a>

                <form class="d-inline-block align-self-center" action="{{ route('subject.destroy', $subject) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                </form>
            </div>
        </div>
    @endforeach
@endsection
