@extends('layouts.app')
@section('content')
    <div class="row">
        <form action="{{ route('category.update', $category) }}" method="post">
            <div class="input-group">
                @csrf
                @method('PATCH')
                <label for="category-name" class="input-group-text rounded-start">Category label</label>
                <input class="form-control" type="text" name="name" id="category-name" value="{{ $category->name }}">
                <input type="submit" value="Update" class="btn btn-primary">
            </div>
        </form>
    </div>
@endsection
