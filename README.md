# Book Store

A software that allow user to search for book and get information such as: title, author, genre, description, publisher, published date. It uses Elasticsearch to perform searches and includes an admin panel for managing the books.

## Getting Started

* Prerequisites 

  Elasticsearch installed and running
  
  Laravel 9

  PHP 8.*

## Installation
1.  Clone the repository

      ```bash
     git clone git@github.com:saurabh-dev01/book-store.git
     ```

2.  Install the dependencies

    ```bash
    composer install
    ```
3. Update Database Details in .env
    ```bash
    DB_DATABASE=db_name
    DB_USERNAME=db_user
    DB_PASSWORD=db_password
    ```
4.  Run Migration 
    ```bash
    php artisan migrate
    ```
5. Run Seeder to store dummy books data from: (https://fakerapi.it/api/v1/books?quantity=100)
   ```bash
     php artisan db:seed --class=BooksTableSeeder  
   ```
6. Run Seeder to store admin credintials
   ```bash
   php artisan db:seed --class=adminCredintialSeeder
   ```
   Email: admin@admin.com

   Password: admin@123
7. Sync Data to Elasticsearch
   
   Login to admin panel and click on sync button, It'll copy books data to elastic search in bulk.
8. Run Project

  ## Serching Books
  The search feature of the software uses Elasticsearch to search books. When user select filter or visit page, the software returns a list of relevant books. To access the details of a single user then click on the Click Here button.

## Admin Panel
   The admin panel allows for the manage books. The following features are available in admin panel:
* Add New Book: Admin can add new book details to database and elastic search using this.
* Edit: Admin can edit books, and it'll automatically edit from the elasticsearch data.
* Delete: Admin can delete books from this.
* Sync: Using this feature admin can copy book database data to elasticsearch
