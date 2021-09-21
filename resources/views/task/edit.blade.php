@extends('layouts.app')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('task.update', $task) }}" class="col-5" method="post">
        @method('PUT')
        @csrf
        <!-- Details -->
        <div class="form-group">
            <label for="task-details">Details</label>
            <textarea cols="30" id="task-details" class="form-control"
                  name="details" rows="10">{{ old('details') ?? $task->details }}</textarea>
        </div>

        <!-- Type -->
        <div class="form-group">
            <label for="task-type">Type</label>
            <select name="type" id="task-type" class="form-control">
                @foreach($task_types as $task_type)
                    <option value="{{ $task_type }}" {{ $task->type === $task_type ? 'selected' : ''}}>
                        {{ ucfirst($task_type) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Subject -->
        <div class="form-group">
            <label for="task-subject">Subject</label>
            <select name="subject_id" id="task-subject" class="form-control">
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Date & Time -->
        <div class="form-group">
            <label for="task-datetime">Date and Time</label>
            <input class="form-control" id="task-datetime" min={{ date('Y-m-d\TH:i:s') }}
                value={{ date('Y-m-d\TH:i:s') }} name="datetime" type="datetime-local">
        </div>

        <button class="btn btn-success form-control">Save</button>
    </form>
@endsection
