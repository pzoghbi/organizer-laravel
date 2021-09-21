@extends('layouts.app')
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="list-unstyled">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('task.store') }}" class="col-5" method="post">
    @csrf
    <div class="form-group mb-3">
        <label for="task-title">Title</label>
        <input type="text" name="title" id="task-title" class="form-control">
    </div>

    <div class="form-group mb-3">
        <label for="task-details">Details</label>
        <textarea cols="30" id="task-details" class="form-control" name="details"
                  rows="10">{{ old('details') }}</textarea>
    </div>

    <div class="form-group mb-3">
        <label for="task-type">Type</label>
        <select name="type" id="task-type" class="form-select mb-3">
            <option value="assignment">Assignment</option>
            <option value="exam">Exam</option>
            <option value="reminder">Reminder</option>
        </select>
    </div>

    <div class="input-group mb-3">
        <label class="input-group-text" for="task-subject">Subject</label>
        <select name="subject_id" id="task-subject" class="form-select">
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
        </select>
        <button type="button" class="btn btn-outline-secondary ms-2 p-0">
            <a class="text-reset text-decoration-none p-2" target="_blank" title="Opens a new page"
               href="{{ route('subject.create') }}">Add a subject</a>
        </button>
    </div>

    <div class="form-group mb-3">
        <label for="task-datetime">Date and Time</label>
        <input class="form-control" id="task-datetime" min="{{ date('Y-m-d\TH:i') }}"
            value="{{ date('Y-m-d\TH:00') }}" name="datetime" type="datetime-local">
    </div>

    <button class="btn btn-success form-control">Save</button>
</form>
@endsection
