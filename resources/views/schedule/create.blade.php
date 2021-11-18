@extends('layouts.app')
@section('content')
    @include('layouts.errors')
{{--    TODO move this to "fill schedule" -> create a view for making a schedule: name, from, to --}}
    <form action="{{ route('schedule.store') }}" method="post">
        @csrf
        <div class="input-group mb-3">
            <label class="input-group-text" for="schedule-name">Schedule name</label>
            <input class="form-control me-3" id="schedule-name" name="name" required type="text">

            <label for="schedule-start" class="input-group-text">Start date</label>
            <input class="form-control me-3" id="schedule-start" name="start" placeholder="dd-mm-yyyy" required
                   type="date" value="{{ date('Y-m-d') }}" >

            <label for="schedule-end" class="input-group-text">End date</label>
            <input class="form-control me-3" id="schedule-end" name="end" placeholder="dd-mm-yyyy" required
                   type="date" value="{{ date('Y-m-d') }}" >

            <input class="btn btn-success text-white" type="submit" value="Save">
        </div>
    </form>
@endsection
