@extends('layouts.app')
@section('content')
    @include('layouts.errors')
    {{--    TODO move this to "fill schedule" -> create a view for making a schedule: name, from, to --}}
    <form action="{{ route('lecture.store') }}" method="post">
        @csrf
        <div class="input-group mb-3">
            <label class="input-group-text" for="lecture-subject">Subject</label>
            <select class="form-select me-3" id="lecture-subject" name="subject_id" required>
                <option value="" selected disabled>Choose a subject</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
            <label class="input-group-text" for="lecture-day">Day</label>
            <select class="form-select me-3" id="lecture-day" name="day" required>
                <option value="" selected disabled>Choose a day</option>
                @for($i = 0; $i < 6; $i++)
                    <option value="{{ $i }}">{{ date('l', strtotime('monday +'. $i .' day')) }}</option>
                @endfor
            </select>
            <label for="schedule-time" class="input-group-text">Time</label>
            <input class="form-control me-3" type="time" name="time" value="12:00" id="lecture-time" required>
            <input class="btn btn-success text-white" type="submit" value="Save">
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">Monday</th>
            <th scope="col">Tuesday</th>
            <th scope="col">Wednesday</th>
            <th scope="col">Thursday</th>
            <th scope="col">Friday</th>
            <th scope="col">Saturday</th>
        </tr>
        </thead>
        <tbody class="schedule">
        </tbody>
    </table>
@endsection

@push('scripts')

@endpush
