@extends('layouts.app')
@section('content')
    @foreach($tasks as $task)
        <div class="row border rounded-3 p-3 mb-3 bg-light shadow">
            <h3 class="h3">{{ $task->title }}</h3>
            <p class="mb-3">
                {{ $task->details }}
            </p>

            <div class="row mb-2">
                <span class="fs-3 w-auto">{{  date_format(date_create($task->datetime), 'd.m. \@ h:i A') }}</span>
                <div class="w-auto">
                    <span class="bg-primary fw-bold text-white shadow rounded-pill px-3 py-1 d-flex">
                        {{ strtoupper($task->type) }}
                    </span>
                </div>

                <div class="w-auto ms-auto">
                    <a href="{{ route('task.show', $task) }}" class="btn btn-primary">Show</a>
                    <a href="{{ route('task.edit', $task) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('task.delete', $task) }}" class="btn btn-danger">Delete</a>
                </div>
            </div>

            <div class="row">
                <span class="w-auto fw-bold rounded-pill shadow me-2">{{ $subjects[$task->subject_id] }}</span>
            </div>
        </div>
    @endforeach
@endsection
