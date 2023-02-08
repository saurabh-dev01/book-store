@extends('layouts.app')

@section('content')
<div class="container">
    <div id="output"></div>
    <form action="{{route('books.update',$book->id)}}" id="form_init" method="post">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $book->title) }}">
        </div>
        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $book->author) }}">
        </div>
        <div class="form-group">
            <label for="genre">Genre</label>
            <input type="text" class="form-control" id="genre" name="genre" value="{{ old('genre', $book->genre) }}">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $book->description) }}</textarea>
        </div>
        <div class="form-group">
            <label for="isbn">ISBN</label>
            <input type="text" class="form-control" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}">
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="text" class="form-control" id="image" name="image" value="{{ old('image', $book->image) }}">
        </div>
        <div class="form-group">
            <label for="publisher">Publisher</label>
            <input type="text" class="form-control" id="publisher" name="publisher" value="{{ old('publisher', $book->publisher) }}">
        </div>
        <div class="form-group">
            <label for="published">Published</label>
            <input type="date" class="form-control" id="published" name="published" value="{{ old('published', $book->published) }}">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
    {{-- End Show Pagination --}}
</div>
@endsection
