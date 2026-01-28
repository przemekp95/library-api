# Books & Authors API

Recruitment task - Laravel REST API for managing books and authors.

## Requirements

The following list describes the minimal, required scope of functionality for this project based on the recruitment task requirements.

### Database
- Relational database used for persistent storage
- Migrations for authors, books and author_book tables
- Proper many-to-many relationship with foreign keys
- Database used in application logic and automated tests

### API Endpoints
- GET /api/books
- GET /api/books/{id}
- POST /api/books
- PUT /api/books/{id}
- DELETE /api/books/{id}
- GET /api/authors
- GET /api/authors/{id}

### API Contract
- JSON responses only
- Proper HTTP status codes
- Eager loading of relations
- Pagination for list endpoints

### Tests
- Feature (HTTP) tests
- Tests for:
  - POST /api/books
  - DELETE /api/books/{id}
- Tests use RefreshDatabase and factories
- HTTP response and database assertions

### Authentication (optional)
- Sanctum used to protect POST /api/books
- Guest request returns 401 Unauthorized
- Authenticated request returns 201 Created

### Search
- GET /api/authors?search=
- Filters authors by related book title
- Implemented using relationship query (whereHas)
- Paginated results

### CI/CD
- GitHub Actions workflow
- Runs on push / pull request
- Installs dependencies
- Runs migrations
- Executes automated tests

### Git Workflow
- Git Flow used
- Feature branches merged into develop
- Final merge from develop to main

## Description

API for managing a library with the following features:
- CRUD operations for books and authors
- Many-to-many relationship between books and authors
- Author search by book title
- Sanctum authentication for book operations
- Job queue for updating author's last book title
- Artisan command for creating authors
- Comprehensive test suite
- CI/CD pipeline

## Getting Started

### Prerequisites

- PHP 8.3+
- Composer
- MySQL 8.0+

This project is API-only. No frontend or Node.js tooling is required.

### Installation

1. Clone the repository
```bash
git clone https://github.com/przemekp95/library-api.git
cd library-api
```

2. Install dependencies
```bash
composer install
```

3. Copy environment file and configure
```bash
cp .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Run migrations and seeders
```bash
php artisan migrate --seed
```

6. Start the development server
```bash
php artisan serve
```

## API Endpoints

### Books (Protected with Sanctum)
- `GET /api/books` - List books with pagination
- `POST /api/books` - Create new book
- `GET /api/books/{id}` - Get book details
- `PUT /api/books/{id}` - Update book
- `DELETE /api/books/{id}` - Delete book

### Authors (Public)
- `GET /api/authors` - List authors with pagination
- `GET /api/authors/{id}` - Get author details
- `GET /api/authors?search=title` - Search authors by book title

## Authentication

Use Sanctum tokens for authentication:
1. Create a user
2. Generate a personal access token
3. Include token in requests: `Authorization: Bearer {token}`

## Features

- **Models**: Author, Book with many-to-many relationship
- **Validation**: FormRequest validation for all inputs
- **Jobs**: Queue job for updating author's last book title
- **Search**: Filter authors by book title
- **Tests**: Feature tests for core functionality
- **CI/CD**: GitHub Actions workflow
- **Artisan Command**: `php artisan app:create-author`

## License

MIT
