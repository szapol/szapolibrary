# szapolibrary

#### Simple library with SQLite database

## Project launch:
1. git clone https://github.com/szapol/szapolibrary.git
2. composer run setup
3. composer run dev

#### Authenticate:
1. POST to localhost:8000/login with json body:
   {
   "email": "test@example.com",
   "password": "password"
   }
2. Save token

#### Authorize:
Add token as bearer token to any protected route (POST, PUT, DELETE)

## Functionality:

### Endpoints:

- GET /api/books?page={page} - return list of books with pagination
- GET /api/books/{id} - return book details
- POST /api/books - create book
- PUT /api/books/{id} - update book
- DELETE /api/books/{id} - delete book
- GET /api/authors?search={query} - return list of authors of books with {query} as part of title (or all if no {query})
- GET /api/authors/{id} - return author details

### Features
- user authentication using Fortify
- request authorization using Sanctum
- add job to queue on new book creation to update all authors' last book title column
- artisan command to create an author with provided first name and last name (php artisan author:create)
- create and delete book feature tests
