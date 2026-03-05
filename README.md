# Simple User API (PHP)

A minimal PHP API project with a custom router and MySQL database.

## Project Structure

```text
simple-user-api/
  docker-compose.yml
  app/
    config/
      Database.php
    controllers/
      UserController.php
    core/
      Router.php
  public/
    index.php
```

## Requirements

- PHP 8.0+ (project uses named arguments in `PDO` and `query` calls)
- PHP extension `pdo_mysql` enabled
- Docker + Docker Compose (for MySQL)

## What It Does

- Registers one route: `GET /users`
- Fetches all rows from `users` table
- Returns JSON response

## Setup

1. Start MySQL with Docker Compose:

```bash
docker compose up -d
```

2. Create the `users` table in MySQL:

```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

3. (Optional) Insert sample data:

```sql
INSERT INTO users (name, email)
VALUES
  ('Marco Paul', 'marco@example.com'),
  ('Alice Paul', 'alice@example.com');
```

4. Start PHP built-in server from project root:

```bash
php -S localhost:8000 -t public
```

5. Test endpoint:

```bash
curl http://localhost:8000/users
```

## Current Database Configuration

Database connection is currently hardcoded in `app/config/Database.php`:

- host: `localhost`
- database: `simple-user-api`
- username: `root`
- password: `secret`

## Route

- `GET /users` -> `UserController::index()`

Expected successful response:

```json
[
  {
    "id": 1,
    "name": "Marco Paul",
    "email": "marco@example.com",
    "created_at": "2026-03-05 10:00:00"
  }
]
```

## Notes

- `Router` matches exact URI from `$_SERVER['REQUEST_URI']`.
- If a route is not found, API returns HTTP `404` with `Route not found`.
- If database connection fails in controller, API returns:

```json
{
  "status": false,
  "message": "Database connection failed"
}
```
