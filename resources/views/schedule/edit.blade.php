@extends('layouts.app')
@section('content')
    @include('layouts.errors')
    @include('layouts.flash')

    {{--    TODO move this to "fill schedule" -> create a view for making a schedule: name, from, to --}}
    <h2 class="h2 text-center mb-5">{{ $schedule->name }}</h2>
    <form action="{{ route('schedule.update', $schedule) }}" method="post" class="mb-5">
        @csrf @method('patch')
        <h5 class="h5 mb-3">Edit schedule dates</h5>
        <div class="input-group mb-3">
            <label for="schedule-start" class="input-group-text">Start date</label>
            <input class="form-control me-3" id="schedule-start" name="start" type="date"
                   value="{{ date('Y-m-d', strtotime($schedule->start)) }}">

            <label for="schedule-end" class="input-group-text">End date</label>
            <input class="form-control me-3" id="schedule-end" name="end" type="date"
                   value="{{ date('Y-m-d', strtotime($schedule->end)) }}">

            <input type="submit" value="Update" class="btn btn-primary text-white">
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-borderless mb-5">
            <thead>
            <tr class="text-center">
                <th class="bg-danger bg-gradient text-white border-bottom-0" scope="col">Monday</th>
                <th class="bg-warning bg-gradient text-dark border-bottom-0" scope="col">Tuesday</th>
                <th class="bg-success bg-gradient text-dark border-bottom-0" scope="col">Wednesday</th>
                <th class="bg-info bg-gradient text-dark border-bottom-0" scope="col">Thursday</th>
                <th class="bg-primary bg-gradient text-white border-bottom-0" scope="col">Friday</th>
                <th class="bg-dark bg-gradient text-white border-bottom-0" scope="col">Saturday</th>
            </tr>
            </thead>
            <tbody class="schedule">
            <tr>
                @for($i = 0; $i < 6; $i++)
                    <td class="p-0">
                        <table class="table table-bordered mb-0">
                            @foreach($schedule->groupLectures() as $key => $lecture_group)
                                @if($i == $key)
                                    @foreach($lecture_group as $lecture)
                                        <tr>
                                            <td class="p-0">
                                                <a class="p-2 gap-1 h-100 w-100 d-block text-decoration-none rounded-0 border-0 text-start text-dark btn btn-outline-info"
                                                   href="{{ route('lecture.edit', $lecture) }}">
                                                    <div class="d-flex">
                                                        <strong>{{ $lecture->subject->name }}</strong>
                                                        <strong class="ms-auto"
                                                                title="Room">{{ $lecture->room }}</strong>
                                                    </div>
                                                    <span>{{ date('H:i', strtotime($lecture->start)) }} - {{ date('H:i', strtotime($lecture->end)) }}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </table>
                    </td>
                @endfor
            </tr>
            </tbody>
        </table>
    </div>

    <form action="{{ route('lecture.store', $schedule->id) }}" class="p-3 shadow border border-1 border-success rounded"
          method="post">
        @csrf
        <h5 class="h5 mb-3">Add a lecture</h5>
        <div class="input-group mb-3">
            <label class="input-group-text" for="lecture-subject">Subject</label>
            <select class="form-select me-3" id="lecture-subject" name="subject_id" required>
                <option value="" selected disabled>Choose a subject</option>
                @foreach(auth()->user()->subjects as $subject)
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

            <label for="lecture-start" class="input-group-text">Start time</label>
            <input class="form-control me-3" type="time" name="start" value="12:00" id="lecture-start" required>

            <label for="lecture-end" class="input-group-text">End time</label>
            <input class="form-control me-3" type="time" name="end" value="13:00" id="lecture-end" required>

            <label for="lecture-room" class="input-group-text">Room</label>
            <input class="form-control" type="text" name="room" placeholder="Room number" id="lecture-room" required>
        </div>
        <hr>
        <div class="form-group d-flex">
            <a class="btn btn-secondary text-white" href="{{ route('schedule.show', $schedule) }}"
               type="submit">Back</a>
            <input class="btn btn-success text-white ms-auto" type="submit" value="Save">
        </div>
    </form>
@endsection
