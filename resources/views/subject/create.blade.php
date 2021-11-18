@extends('layouts.app')
@section('content')
    <form action="{{ route('subject.store') }}" method="post">
        @csrf
        <div class="input-group mb-3">
            <label class="input-group-text" for="subject-name">Subject name</label>
            <input class="form-control" type="text" name="name" id="subject-name" required>
        </div>
        <div class="input-group mb-3">
            <label class="input-group-text" for="subject-color">Color (optional)</label>
            <input class="form-control-color" type="color" name="color" id="subject-color">
        </div>
        <div class="d-flex">
            <button class="btn btn-primary ms-auto text-white" type="submit">Add</button>
        </div>
    </form>
@endsection
