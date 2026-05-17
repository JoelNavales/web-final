# PHP MVC Framework — Task Manager MVP

A hand-built PHP 8.3+ MVC framework demonstrating SOLID principles with Doctrine ORM for persistence.

---

## Requirements

- PHP 8.3 or higher (tested on PHP 8.5)
- Composer
- SQLite extension (built into PHP by default) **or** MySQL 5.7+ / MariaDB 10.3+

---

## Setup

### 1. Install dependencies

```bash
composer install
```

### 2. Configure the database

The default driver is **SQLite** (zero-config). No changes are needed.

To switch to MySQL, edit `config/database.php`:

```php
'default' => 'mysql', 

'connections' => [
    'mysql' => [
        'host'     => '127.0.0.1',
        'database' => 'task_manager',
        'username' => 'root',
        'password' => 'your_password',
        ...
    ],
],
```

### 3. Create the database schema

```bash
php bin/console.php schema:create
```

To update after entity changes:

```bash
php bin/console.php schema:update
```

### 4. Start the development server

```bash
php -S localhost:8000 -t public/
```

Open `http://localhost:8000` in your browser.

---

## Routes

| Method | URI                    | Controller Method         | Description              |
|--------|------------------------|---------------------------|--------------------------|
| GET    | `/`                    | HomeController@index      | Welcome page             |
| GET    | `/tasks`               | TaskController@index      | List all tasks           |
| GET    | `/tasks/create`        | TaskController@create     | Show create form         |
| POST   | `/tasks`               | TaskController@store      | Persist a new task       |
| GET    | `/tasks/{id}`          | TaskController@show       | Show a single task       |
| GET    | `/tasks/{id}/edit`     | TaskController@edit       | Show edit form           |
| POST   | `/tasks/{id}/update`   | TaskController@update     | Persist task changes     |
| POST   | `/tasks/{id}/delete`   | TaskController@destroy    | Delete a task            |

---

## Task Fields

| Field         | Type                     | Required | Notes                              |
|---------------|--------------------------|----------|------------------------------------|
| `title`       | string (max 255)         | Yes      |                                    |
| `description` | text                     | No       | max 5 000 characters               |
| `status`      | enum                     | Yes      | `pending`, `in_progress`, `completed` |
| `due_date`    | date (YYYY-MM-DD)        | No       |                                    |
| `created_at`  | datetime (auto)          | —        | Set on first persist               |
| `updated_at`  | datetime (auto)          | —        | Updated on every save              |

---

## Architecture Overview

### Why Doctrine ORM?

Doctrine ORM is a declared micro-library within the rubric's allowance for external persistence libraries. It provides:

- **Type-safe entities** via PHP 8 attributes (`#[Entity]`, `#[Column]`, etc.)
- **Attribute mapping** — no XML/YAML config files, mapping lives with the class
- **Unit of Work pattern** — the framework focuses on HTTP routing and DI rather than reinventing persistence
- **SchemaTool** — schema management without raw SQL

### Why are Router and Dispatcher split?

`Router` has one job: match an HTTP method + path to a handler. `Application` has one job: invoke that handler via the container. Merging them would give `Router` knowledge of controllers and the DI container — a clear SRP violation. The split also makes the router trivially testable in isolation.

### Why interface-based repositories?

`TaskController` depends on `TaskRepositoryInterface`, not `TaskRepository`. This means:

1. The controller can be tested with any object implementing the interface (mock, in-memory stub).
2. Swapping the persistence backend (SQLite → MySQL → anything) requires zero changes to the controller.
3. It visibly demonstrates the Dependency Inversion Principle.

---

## Commands Reference

```bash
# Schema
php bin/console.php schema:create
php bin/console.php schema:update

# Start server (from my-mvc-framework/ directory)
php -S localhost:8000 -t public/

# Regenerate autoloader after adding new classes
composer dump-autoload
```
