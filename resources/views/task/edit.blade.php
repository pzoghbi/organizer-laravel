@extends('layouts.app')
@section('content')
    @include('layouts.errors')
    <form action="{{ route('task.update', $task) }}" method="post">
        @method('PUT')
        @csrf

        <!-- Title -->
        <div class="form-group mb-3">
            <label for="task-title">Title</label>
            <input type="text" name="title" id="task-title" class="form-control"
                   value="{{ old('title') ?? $task->title }}">
        </div>

        <!-- Details -->
        <div class="form-group mb-3">
            <label for="task-details">Details</label>
            <textarea cols="30" id="task-details" class="form-control"
                  name="details" rows="10">{{ old('details') ?? $task->details }}</textarea>
        </div>

        <!-- Type -->
        <div class="form-group mb-3">
            <label for="task-type">Type</label>
            <select name="type" id="task-type" class="form-control">
                @foreach(['reminder', 'assignment', 'exam'] as $task_type)
                    <option value="{{ $task_type }}" {{ $task->type === $task_type ? 'selected' : ''}}>
                        {{ ucfirst($task_type) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Subject -->
        <div class="input-group mb-3">
            <label class="input-group-text" for="task-subject">Subject</label>
            <select name="subject_id" id="task-subject" class="form-select">
                @foreach(auth()->user()->subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-outline-secondary ms-2 p-0">
                <a class="text-reset text-decoration-none p-2" target="_blank" title="Opens new page"
                   href="{{ route('subject.create') }}">Add a subject</a>
            </button>
        </div>

        <!-- Date & Time -->
        <div class="form-group mb-3">
            <label for="task-datetime">Date and Time</label>
            <input class="form-control" id="task-datetime" min="{{ date('Y-m-d\TH:i') }}"
                value="{{ date_format(date_create($task->datetime), 'Y-m-d\TH:i') }}" name="datetime" type="datetime-local">
        </div>

        <button class="btn btn-success form-control">Save</button>
    </form>
@endsection
