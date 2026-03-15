# Simple User API (PHP)

A simple PHP REST API for managing users, with a small vanilla JavaScript frontend.

## Features

- Custom PHP router (no framework)
- MySQL database with PDO
- Full CRUD operations: list, create, update, and delete users
- Interactive frontend with auto-loading user list

## Project Structure

```text
simple-user-api/
  docker-compose.yml
  README.md
  app/
    config/
      Database.php
    controllers/
      UserController.php
    core/
      Router.php
  models/
    User.php
  public/
    index.php
  frontend/
    index.html
    app.js
    style.css
```

## Requirements

- PHP 8.0+
- PHP extension `pdo_mysql`
- Docker + Docker Compose (for local MySQL)

## Quick Start

1. Start MySQL:

```bash
docker compose up -d
```

2. Create the `users` table:

```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

3. Optional seed data:

```sql
SOURCE database/seeds/users.sql;
```

4. Start the API server from project root:

```bash
php -S localhost:8000 -t public
```

5. Open the frontend:

- Open `frontend/index.html` in your browser.
- User list loads automatically on page load.
- Use the forms to create, update, or delete users.

## API Base URL

`http://localhost:8000`

## Endpoints

### `GET /users`

Returns all users.

Example response:

```json
[
  {
    "id": 1,
    "name": "Marco Paul",
    "email": "marco@example.com",
    "username": "marcop"
  }
]
```

### `POST /users`

Creates a user.

Request body:

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "username": "johnd",
  "password": "secret123"
}
```

Validation:

- `name`, `email`, `username`, and `password` are required.

### `PUT /users`

Updates a user.

Request body:

```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "username": "johnd",
  "password": "secret123"
}
```

Validation:

- `id`, `name`, `email`, `username`, and `password` are required.

### `DELETE /users`

Deletes a user.

Request body:

```json
{
  "id": 1
}
```

Validation:

- `id` is required.
- Returns 404 if user not found.

## cURL Examples

Get all users:

```bash
curl http://localhost:8000/users
```

Create user:

```bash
curl -X POST http://localhost:8000/users \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","username":"johnd","password":"secret123"}'
```

Update user:

```bash
curl -X PUT http://localhost:8000/users \
  -H "Content-Type: application/json" \
  -d '{"id":1,"name":"John Updated","email":"john@example.com","username":"johnd","password":"secret123"}'
```

Delete user:

```bash
curl -X DELETE http://localhost:8000/users \
  -H "Content-Type: application/json" \
  -d '{"id":1}'
```

## Database Configuration

Current connection settings in `app/config/Database.php`:

- Host: `localhost`
- Database: `simple-user-api`
- Username: `root`
- Password: `secret`

These values match `docker-compose.yml` defaults.

## Notes

- Router uses exact URI matching from `$_SERVER['REQUEST_URI']`.
- CORS headers are configured in `public/index.php` (supports GET, POST, PUT, DELETE).
- Unknown routes return HTTP `404` with message `Route not found`.
- Frontend displays user ID in the list for easy reference when updating or deleting.
