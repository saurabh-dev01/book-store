@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
              <img src="{!! $book->image !!}" alt="{!! $book->title !!}" class="img-fluid">
            </div>
            <div class="col-md-8">
              <h1>{!! $book->title !!}</h1>
              <h2>{!! $book->author !!}</h2>
              <p><strong>Publisher:</strong> {!! $book->publisher !!}</p>
              <p><strong>Published Date:</strong> {!! $book->published_date !!}</p>
              <p><strong>ISBN:</strong> {!! $book->isbn !!}</p>
              <p><strong>Genre:</strong> {!! $book->genre !!}</p>
              <p>{!! $book->description !!}</p>
            </div>
          </div>
    </div>
@endsection
