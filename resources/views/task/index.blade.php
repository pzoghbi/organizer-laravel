@extends('layouts.app')
@section('content')
    <div class="row mb-3">
        <h1 class="h5 px-2 py-1 bg-secondary rounded-top text-light">Your dashboard</h1>
    </div>
    <div class="row mb-3">
        <h3 class="h3 w-auto d-inline-block text-secondary">Upcoming tasks</h3>
        <a class="btn btn-success ms-auto w-auto h-100 text-white" href="{{ route('task.create') }}">Create</a>
    </div>
    @foreach($tasks as $task)
        <div class="row border rounded-3 p-3 mb-3 bg-light shadow">
            <h3 class="h3">{{ $task->title }}</h3>
            <p class="mb-3">
                {{ $task->details }}
            </p>

            <div class="row mb-2">
                <span class="fs-3 w-auto">{{  date_format(date_create($task->datetime), 'd.m. \@ h:i A') }}</span>
                <div class="w-auto align-self-center">
                    <span class="bg-primary fw-bold text-white shadow rounded-pill px-2 d-flex">
                        {{ strtoupper($task->type) }}
                    </span>
                </div>

                <div class="w-auto ms-auto">
                    <a class="btn btn-primary text-white" href="{{ route('task.show', $task) }}">Show</a>
                    <a class="btn btn-warning" href="{{ route('task.edit', $task) }}">Edit</a>
                    <a class="btn btn-danger text-white" href="{{ route('task.delete', $task) }}">Delete</a>
                </div>
            </div>

            <div class="row">
                <span class="w-auto fw-bold rounded-pill bg-warning me-2">{{ $subjects[$task->subject_id] }}</span>
            </div>
        </div>
    @endforeach
@endsection
