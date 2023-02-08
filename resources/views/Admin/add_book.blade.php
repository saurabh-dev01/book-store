@extends('layouts.app')

@section('content')
<div class="container">
    <div id="output"></div>
    <form action="{{route('book.save')}}" method="post" id="form_init">
        @csrf
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" >
        </div>
        <div class="form-group">
            <label for="author">Author:</label>
            <input type="text" class="form-control" id="author" name="author" >
        </div>
        <div class="form-group">
            <label for="genre">Genre:</label>
            <input type="text" class="form-control" id="genre" name="genre" >
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="3" ></textarea>
        </div>
        <div class="form-group">
            <label for="isbn">ISBN:</label>
            <input type="text" class="form-control" id="isbn" name="isbn" >
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="text" class="form-control" id="image" name="image" >
        </div>
        <div class="form-group">
            <label for="published">Published:</label>
            <input type="date" class="form-control" id="published" name="published">
        </div>
        <div class="form-group">
            <label for="publisher">Publisher:</label>
            <input type="text" class="form-control" id="publisher" name="publisher" >
        </div>
        <button type="submit" class="btn btn-primary mt-3">Add Book</button>
    </form>
    {{-- End Show Pagination --}}
</div>
@endsection
