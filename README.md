# Simple User API (PHP)

A simple PHP REST API for managing users, with a small vanilla JavaScript frontend.

## Features

- Custom PHP router (no framework)
- MySQL database with PDO
- Endpoints to list, create, and update users
- Basic frontend to create users and fetch all users

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
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

3. Optional seed data:

```sql
INSERT INTO users (name, email, username)
VALUES
  ('Marco Paul', 'marco@example.com', 'marcop'),
  ('Alice Paul', 'alice@example.com', 'alicep');
```

4. Start the API server from project root:

```bash
php -S localhost:8000 -t public
```

5. Open the frontend:

- Open `frontend/index.html` in your browser.
- Use the form to create users.
- Click "Get users" to list all users.

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
  "username": "johnd"
}
```

Validation:

- `name`, `email`, and `username` are required.

### `PUT /users`

Updates a user.

Request body:

```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "username": "johnd"
}
```

Validation:

- `id`, `name`, `email`, and `username` are required.

## cURL Examples

Get all users:

```bash
curl http://localhost:8000/users
```

Create user:

```bash
curl -X POST http://localhost:8000/users \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","username":"johnd"}'
```

Update user:

```bash
curl -X PUT http://localhost:8000/users \
  -H "Content-Type: application/json" \
  -d '{"id":1,"name":"John Updated","email":"john@example.com","username":"johnd"}'
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
- CORS headers are configured in `public/index.php`.
- Unknown routes return HTTP `404` with message `Route not found`.
