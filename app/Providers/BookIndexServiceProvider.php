<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Elastic\Elasticsearch\ClientBuilder;
class BookIndexServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        $client = ClientBuilder::create()->build();
        $params = [
            'index' => 'books',
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0
                ],
                'mappings' => [
                    '_source' => [
                        'enabled' => true
                    ],
                    'properties' => [
                        'title' => [
                            'type' => 'text'
                        ],
                        'author' => [
                            'type' => 'text'
                        ],
                        'genre' => [
                            'type' => 'text'
                        ],
                        'description' => [
                            'type' => 'text'
                        ],
                        'image' => [
                            'type' => 'text'
                        ],
                        'isbn' => [
                            'type' => 'text'
                        ],
                        'published' => [
                            'type' => 'date',
                            'format' => 'yyyy-MM-dd'
                        ],
                        'publisher' => [
                            'type' => 'text'
                        ]
                    ]
                ]
            ]
        ];
        $client->indices();
    }
}
