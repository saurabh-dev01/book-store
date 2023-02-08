@extends('layouts.app')

@section('content')
  
  <!-- filter section start -->
  <section>
    <div class="container filter">
      <form action="#" method="GET">
        <div class="form-row row">
          <div class="col-md-2 mb-1">
            <label>Title<label>
            <input type="text" class="form-control" name="title" placeholder="Title">
          </div>
          <div class="col-md-2 mb-1">
          <label>Author<label>
            <input type="text" class="form-control" name="author" placeholder="Author">
          </div>
          <div class="col-md-2 mb-1">
          <label>Publisher<label>
            <input type="text" class="form-control" name="publisher" placeholder="Publisher">
          </div>
          <div class="col-md-2 mb-1">
            <label>Publication Date<label>
            <input type="date" class="form-control" name="publication_date" placeholder="Publication Date">
          </div>
          <div class="col-md-2 mb-1">
          <label>ISBN<label>
            <input type="text" class="form-control" name="ISBN" placeholder="ISBN">
          </div>
          <div class="col-md-1 mb-1">
            <label>Genre</label>
            <input type="text" class="form-control" name="genre" placeholder="Genre">
          </div>
          <div class="col-md-1 mb-1">
            <label>&nbsp;<label>
            <button type="submit" class="btn btn-primary">Search</button>
          </div>
        </div>  
      </form>
    </div>
  </section>
  <!-- End filter section -->

  <!-- Book detail Section -->
  <section class="books">
    <div class="container mt-5">
    <div class="row">
      @foreach ($books as $book)
        <div class="col-md-4">
          <div class="card mb-4">
            <img class="card-img-top" src="{{ $book->image }}" alt="{{ $book->title }}">
            <div class="card-body">
              <h5 class="card-title">{{ $book->title }}</h5>
              <p class="card-text">{{ $book->description }}</p>
              <p class="card-text">Author: {{ $book->author }}</p>
              <div class="row">
                <div class="col-6 col-lg-7">
                  <p class="card-text">ISBN: {{ $book->isbn }}</p>
                </div>
                <div class="col-6 col-lg-5">
                  <p class="card-text">Genre: {{ $book->genre }}</p>
                </div>
                <div class="col-6 col-lg-7">
                  <p class="card-text">Published: {{ $book->published }}</p>
                </div>
                <div class="col-6 col-lg-5">
                  <p class="card-text">Publisher: {{ $book->publisher }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    {{-- Show pagination --}}
    @if ($books->hasPages())
      <div class="pagination-wrapper">
        {{$books->links()}}
      </div>
    @endif
    {{-- End Show Pagination --}}

  </div>
  <section>
  <!-- End Book Detail Section -->
@endsection
  <!-- Section -->
  
  <!-- End Section -->
