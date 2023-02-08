<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create a new instance of the guzzle client
        $client = new Client();

        
        
        $books_data = [];

        // for($i =1; $i<=10;$i++){
            //make a get request to given url to retrieve the books data
            $response = $client->get('http://fakerapi.it/api/v1/books?_quantity=100');

            if($response->getStatusCode() == 200){

                $books = json_decode($response->getBody()->getContents());
                        
                foreach($books->data as $book){
                    $books_data[] = [
                        'title' => $book->title,
                        'author' => $book->author,
                        'genre' => $book->genre,
                        'description' => $book->description,
                        'isbn' => $book->isbn,
                        'image' => $book->image,
                        'published' => $book->published,
                        'publisher' => $book->publisher,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString()
                    ];
                }
            }
        // }
        

        

        //save books data into books table
        DB::table('books')->insert($books_data);

    }
}
