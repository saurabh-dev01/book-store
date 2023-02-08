@extends('layouts.app')

@section('content')
<div class="container">
    
    @if(Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <a href="{{route('books.sync')}}" class="btn btn-primary mb-3">Sync</a>
            <a href="{{route('book.add')}}" class="btn btn-primary mb-3">Add New Book</a>
        </div>
        <div class="col-lg-4">

        </div>
    </div>
    <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th scope="col">Title</th>
            <th scope="col">Author</th>
            <th scope="col">Genre</th>
            <th scope="col">Description</th>
            <th scope="col">ISBN</th>
            <th scope="col">Image</th>
            <th scope="col">Published</th>
            <th scope="col">Publisher</th>
            <th scope="col" width="120px">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Loop through the books data -->

          @foreach($books as $book)
          <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->genre }}</td>
            <td>{{ $book->description }}</td>
            <td>{{ $book->isbn }}</td>
            <td><img src="{{ $book->image }}" width="50" height="50" /></td>
            <td>{{ $book->published }}</td>
            <td>{{ $book->publisher }}</td>
            <td>
              <!-- Edit button -->
              <a href="{{route('books.edit',$book->id)}}" class="btn btn-primary">
                <i class="fa fa-edit"></i>
              </a>
              <a href="{{route('books.delete',$book->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure to delete?')">
                <i class="fa fa-trash"></i>
              </a>
              <!-- Delete button -->
              
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    
      {{-- Show pagination --}}
        @if ($books->hasPages())
        <div class="pagination-wrapper">
        {{$books->links()}}
        </div>
    @endif
    {{-- End Show Pagination --}}
</div>
@endsection
