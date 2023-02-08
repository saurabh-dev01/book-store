@extends('layouts.app')

@section('content')
  
  <!-- filter section start -->
  <section>
    <div class="container filter">
      <form action="#" method="GET">
        <div class="form-row row">
          <div class="col-md-2 mb-1">
            <label>Title<label>
            <input type="text" class="form-control" name="title" placeholder="Title" value="{{app('request')->input('title')}}">
          </div>
          <div class="col-md-2 mb-1">
          <label>Author<label>
            <input type="text" class="form-control" name="author" placeholder="Author" {{app('request')->input('author')}}>
          </div>
          <div class="col-md-2 mb-1">
          <label>Publisher<label>
            <input type="text" class="form-control" name="publisher" placeholder="Publisher" {{app('request')->input('publisher')}}>
          </div>
          <div class="col-md-2 mb-1">
            <label>Published Date<label>
            <input type="date" class="form-control" name="published"  value="{{app('request')->input('published')}}">
          </div>
          <div class="col-md-2 mb-1">
          <label>ISBN<label>
            <input type="text" class="form-control" name="ISBN" placeholder="ISBN" value="{{app('request')->input('isbn')}}">
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
            <img class="card-img-top" src="{{ $book['_source']['image'] }}" alt="{{ $book['_source']['title'] }}">
            <div class="card-body">
              <h5 class="card-title">{{ $book['_source']['title'] }}</h5>
              <p class="card-text">{{ $book['_source']['description'] }}</p>
              <p class="card-text">Author: {{ $book['_source']['author'] }}</p>
              <div class="row">
                <div class="col-6 col-lg-7">
                  <p class="card-text">ISBN: {{ $book['_source']['isbn'] }}</p>
                </div>
                <div class="col-6 col-lg-5">
                  <p class="card-text">Genre: {{ $book['_source']['genre'] }}</p>
                </div>
                <div class="col-6 col-lg-7">
                  <p class="card-text">Published: {{ $book['_source']['published'] }}</p>
                </div>
                <div class="col-6 col-lg-5">
                  <p class="card-text">Publisher: {{ $book['_source']['publisher'] }}</p>
                </div>
              </div>
              <div class="">
                <a href="{{route('view.book',$book['_source']['isbn'])}}" class="btn btn-primary mb-3">Click Here</a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
      @if(count($books) == 0)
        <div class="col-lg-12 text-center">
            <div class="alert alert-danger">
                No Record Found
            </div>
        </div>  
      @endif
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
