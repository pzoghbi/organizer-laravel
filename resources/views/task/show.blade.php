@extends('layouts.app')
@section('content')
    <div
        class="shadow card mb-1 border-0 border-5 border-start {{ $task->active ? 'border-warning' : 'border-success' }}">
        <div class="card-header d-flex">
            <h3 class="h3">{{ $task->title }}</h3>
            <span
                class="badge rounded-pill bg-danger ms-auto fs-6 h-100 align-self-center">{{ $task->subject_name }}</span>
        </div>

        <div class="card-body">
            <div class="d-flex fs-4 mb-3">
                <span>{{ date('H:i', strtotime($task->datetime)) }}</span>
                <span class="ms-auto">{{ date('d.m.Y', strtotime($task->datetime)) }}</span>
            </div>

            <p>{{ $task->details }}</p>

            <div class="d-flex gap-2">
                <form id="complete-task-{{ $task->id }}" class="d-inline" action="{{ route('task.complete', $task) }}"
                      method="post">@csrf @method('PATCH')
                    <input class="btn {{ $task->active ? 'btn-success' : 'btn-danger' }} text-white" type="submit"
                           value="Mark {{ $task->active ? 'complete' : 'incomplete' }}"
                           form="complete-task-{{ $task->id }}">
                </form>

                <a href="{{ route('task.edit', $task) }}" class="ms-auto btn btn-warning">Edit</a>
                <a href="{{ route('task.delete', $task) }}" class="btn btn-outline-danger">Delete</a>
            </div>

        </div>
    </div>
@endsection
