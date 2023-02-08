<?php

namespace App\Http\Controllers;

use App\Models\books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\BookRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
class bookController extends Controller
{
    private $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        // assign the bookrepository instance to a private property
        $this->bookRepository = $bookRepository;
        
    }
    function index(){

        $books = DB::table('books')->paginate(9);
        return view('demo',[
            'books'=> $books
        ]);
    }
    function fetch_in_dashboard(){
        $books = DB::table('books')->orderBy('id','DESC')->paginate(9);
        return view('home',[
            'books'=> $books
        ]);
    }

    public function syncAllBooksToElasticsearch()
    {
        // Retrieve all book records from the database
        $books = books::all();

        try{
            // Iterate over each book and index it in Elasticsearch
            foreach ($books as $book) {
                $this->bookRepository->index($book);
            } 
            session()->flash('success', 'All books have been successfully synced to Elasticsearch');
        }
        catch (\Exception $e) {
                // Log the error
            session()->flash('error', 'All books have been successfully synced to Elasticsearch');
        }
        

        // Set a success flash message
        

        // Redirect back to the previous page
        return redirect()->back();
    }

    function editbook($id){
        $book = books::find($id);
        return view('Admin/edit_book')->with('book',$book);
    }

    function update(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'author' => 'required',
                'genre' => 'required',
                'description' => 'required',
                'isbn' => 'required',
                'image' => 'required|url',
                'published' => 'required|date',
                'publisher' => 'required'  
            ],
            [
                'title.required' => 'Enter Title',
                'author.required' =>'Enter Author',
                'genre.required' => 'Enter Genre',
                'description.required' => 'Enter Description',
                'isbn.required' => 'Enter ISBN',
                'image.required' => 'Enter Image URL',
                'image.url' => 'Enter Valid Image URL',
                'published.required' => 'Select Published Date',
                'publisher.required' => 'Enter Publisher Name'
            ]
        );

        $values = [
            'title' => $request->title,
            'author' => $request->author,
            'genre' => $request->genre,
            'description' => $request->description,
            'isbn' => $request->isbn,
            'image' => $request->image,
            'published' => $request->published,
            'publisher' => $request->publisher,
        ];

        //run validation which will redirect on failure
        // $validator->validate();
        

        if ($validator->passes()) {
            // update data in database
            $update_query = DB::table('books')->WHERE('id', $request->id)->update($values);
            // udpate data in elastic search
            if($this->bookRepository->update($request->id, $request->all())){
                return Response()->json(
                    [
                        'status' => 1,
                        'msg' => 'Record Updated',
                        'url' => route('books')
                    ]
                );
            }
            
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->all()]);
    }
    function delete($id){
        // find the book in database
        $book = books::WHERE('id', $id)->first();
        
        // check if record exist
        if(!$book){
            session()->flash('error', 'Please Try Again');
            return redirect()->back();
        }

        // query to delete
        $query = books::WHERE('id', $id)->delete();
        // if($query){
            // delete the record from elasticsearch
            $this->bookRepository->delete($id);
            session()->flash('success', 'Record Deleted Successfully');
            return redirect()->back();
        // }
    }

    function save(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'author' => 'required',
                'genre' => 'required',
                'description' => 'required',
                'isbn' => 'required',
                'image' => 'required|url',
                'published' => 'required|date',
                'publisher' => 'required'  
            ],
            [
                'title.required' => 'Enter Title',
                'author.required' =>'Enter Author',
                'genre.required' => 'Enter Genre',
                'description.required' => 'Enter Description',
                'isbn.required' => 'Enter ISBN',
                'image.required' => 'Enter Image URL',
                'image.url' => 'Enter Valid Image URL',
                'published.required' => 'Select Published Date',
                'publisher.required' => 'Enter Publisher Name'
            ]
        );

        $values = [
            'title' => $request->title,
            'author' => $request->author,
            'genre' => $request->genre,
            'description' => $request->description,
            'isbn' => $request->isbn,
            'image' => $request->image,
            'published' => $request->published,
            'publisher' => $request->publisher,
        ];

        //run validation which will redirect on failure
        // $validator->validate();
        

        if ($validator->passes()) {
            // add record in database
            $get_record_id = DB::table('books')->insertGetId($values);
            
            if($get_record_id){
                $book = books::find($get_record_id);
                $this->bookRepository->index($book);

                return Response()->json(
                    [
                        'status' => 1,
                        'msg' => 'Book Added Successfully',
                        'url' => route('books')
                    ]
                );
            };    
        }
        return response()->json(['status' => 0, 'error' => $validator->errors()->all()]);
    }

    function elastic_paginator(Request $request, $page = 1)
    {

        if ($request->get('page')) {
            $page = $request->get('page');
        } else {
            $page = 1;
        }
    
        $queryArray = [];
    
        if ($request->get('title')) {
            $queryArray['title'] = $request->get('title');
        }
        if ($request->get('author')) {
            $queryArray['author'] = $request->get('author');
        }
        if ($request->get('publisher')) {
            $queryArray['publisher'] = $request->get('publisher');
        }
        if ($request->get('published')) {
            $queryArray['published'] = $request->get('published');
        }
        if ($request->get('isbn')) {
            $queryArray['isbn'] = $request->get('isbn');
        }
        if ($request->get('genre')) {
            $queryArray['genre'] = $request->get('genre');
        }
        
        if (empty($queryArray)) {
            
            $results = $this->bookRepository->getAllBooks($page);
        } else {
            
            $results = $this->bookRepository->searchByFields($queryArray, $page);
        }
        
        
        // dd($results);
        $total = $results['hits']['total']['value'];
        $perPage = 10;
        $books = $results['hits']['hits'];
        
        $paginator = new LengthAwarePaginator($books, $total, $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query()
        ]);
        
        // dd($paginator);
        return view('books',[
            'books'=> $paginator
        ]);
    }

    function check_single_book(Request $request){
        $book = books::WHERE('isbn', $request->isbn)->first();
        return view('single_book_page',[
            'book' => $book
        ]);
    }
}
