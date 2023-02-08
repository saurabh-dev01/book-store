<?php
namespace App\Repositories;

use App\Models\books;
use Elastic\Elasticsearch\ClientBuilder;

class BookRepository
{
    private $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }

    public function index(books $book)
    {
        $params = [
            'index' => 'books',
            'id' => $book->id,
            'body' => [
                'title' => $book->title,
                'author' => $book->author,
                'genre' => $book->genre,
                'description' => $book->description,
                'isbn' => $book->isbn,
                'image' => $book->image,
                'published' => $book->published,
                'publisher' => $book->publisher
            ]
        ];
        // dd($params);
        $this->client->index($params);
        
    }

    // public function search($filters)
    // {
    //     $query = [
    //         'bool' => [
    //             'must' => []
    //         ]
    //     ];

    //     foreach ($filters as $field => $value) {
    //         if (!empty($value)) {
    //             $query['bool']['must'][] = [
    //                 'match' => [
    //                     $field => $value
    //                 ]
    //             ];
    //         }
    //     }

    //     $results = $this->client->search([
    //         'index' => 'books',
    //         'body' => [
    //             'query' => $query
    //         ]
    //     ]);

    //     return $results['hits']['hits'];
    // }

    public function update($id, $data)
    {
        
        $params = [
            'index' => 'books',
            'id' => $id,
            'body' => [
                'doc' => $data
            ]
        ];
        // dd();
        $response = $this->client->update($params);
        return true;
        // return $response['result'] == 'updated';
    }

    public function delete($id){
        // define the parameters for deleting the document
        $params = [
            'index' => 'books',
            'id' => $id
        ];

        try{
            //delete the value from elastisearch node
            $this->client->delete($params);
            return true;
        }
        catch(\Exception $e){
            return false;
        }
    }
    // search function for pagination
    public function search($query, $page =1, $perPage=10)
    {
        $from = ($page - 1) * $perPage;
        $searchParams = [
            'index' => 'books',
            'body' => [
                'query' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => ['title', 'author','genre','description','isbn', 'publisher', 'publish_date']
                    ]
                ],
                'from' => $from,
                'size' => $perPage
            ]
        ];
        return $this->client->search($searchParams);
    }
    // get all books from elasticsearch with pagination
    public function getAllBooks($page)
    {
        $params = [
            'index' => 'books',
            'from' => ($page - 1) * 10,
            'size' => 10,
        ];
        $results = $this->client->search($params);
        return $results;
    }
    // search by fields for filter
    public function searchByFields($queryArray, $page = 1, $perPage = 10)
    {
        $from = ($page - 1) * $perPage;
        $boolQuery = [];
        
        foreach($queryArray as $field => $value) {
            if(!empty($value)) {
                $boolQuery[] = [
                    'match' => [
                        $field => $value
                    ]
                ];
            }
        }

        $searchParams = [
            'index' => 'books',
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => $boolQuery
                    ]
                ],
                'from' => $from,
                'size' => $perPage
            ]
        ];

        return $this->client->search($searchParams);
    }
}
