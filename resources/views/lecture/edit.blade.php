@extends('layouts.app')
@section('content')
    @include('layouts.errors')
    <h2 class="h2 text-center mb-3">{{ $lecture->schedule->name }}</h2>
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
                        @foreach($lecture->schedule->groupLectures() as $key => $lecture_group)
                            @if($i == $key)
                                @foreach($lecture_group as $lecture_record)
                                    <tr>
                                        <td class="p-0">
                                            <a class="p-2 h-100 w-100 d-block text-decoration-none rounded-0 border-0 text-start {{ $lecture_record->id == $lecture->id ? "bg-primary text-white": "text-dark btn btn-outline-info " }}"
                                               href="{{ route('lecture.edit', $lecture_record) }}">
                                                <div class="d-flex">
                                                    <strong>{{ $lecture_record->subject->name }}</strong>
                                                    <strong class="ms-auto"
                                                            title="Room">{{ $lecture_record->room }}</strong>
                                                </div>
                                                <span>{{ date('H:i', strtotime($lecture_record->start)) }} - {{ date('H:i', strtotime($lecture_record->end)) }}</span>
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
    <div class="p-3 shadow border border-1 border-primary rounded">
        <form action="{{ route('lecture.update', $lecture) }}" id="lecture_update" method="post">
            @method('patch')
            @csrf
            <h5 class="h5 mb-3">Edit the lecture</h5>
            <div class="input-group mb-3">
                <label class="input-group-text" for="lecture-subject">Subject</label>
                <select class="form-select me-3" id="lecture-subject" name="subject_id" required>
                    <option value="" selected disabled>Choose a subject</option>
                    @foreach(auth()->user()->subjects as $key => $subject)
                        <option
                            value="{{ $subject->id }}" {{ $subject->id == $lecture->subject_id ? 'selected' : '' }}>{{ $subject->name }}</option>
                    @endforeach
                </select>

                <label class="input-group-text" for="lecture-day">Day</label>
                <select class="form-select me-3" id="lecture-day" name="day" required>
                    <option value="" selected disabled>Choose a day</option>
                    @for($i = 0; $i < 6; $i++)
                        <option value="{{ $i }}" {{ $i == $lecture->day ? 'selected' : '' }}>
                            {{ date('l', strtotime('monday +'. $i .' day')) }}</option>
                    @endfor
                </select>

                <label for="lecture-start" class="input-group-text">Start time</label>
                <input class="form-control me-3" type="time" name="start"
                       value="{{ date('H:i', strtotime($lecture->start)) }}" id="lecture-start" required>

                <label for="lecture-end" class="input-group-text">End time</label>
                <input class="form-control me-3" type="time" name="end"
                       value="{{ date('H:i', strtotime($lecture->end)) }}" id="lecture-end" required>

                <label for="lecture-room" class="input-group-text">Room</label>
                <input class="form-control" type="text" name="room" placeholder="Room number"
                       value="{{ $lecture->room }}" id="lecture-room" required>
            </div>
        </form>
        <hr/>
        <div class="form-group d-flex">
            <a class="btn btn-secondary text-white me-2" href="{{ route('schedule.edit', $lecture->schedule) }}"
               type="submit">Cancel</a>

            <form action="{{ route('lecture.destroy', $lecture) }}" method="post">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger" type="submit">Delete</button>
            </form>

            <input class="btn btn-primary text-white ms-auto" type="submit" form="lecture_update" value="Update">
        </div>
    </div>
@endsection
