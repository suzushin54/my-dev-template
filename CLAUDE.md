# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

This is a Laravel 9 development template using Docker. The stack includes:
- PHP 8.2.1 (FPM Alpine)
- MySQL 8.0
- Redis (latest)
- Nginx
- Node.js/npm with Vite for frontend assets

## Docker Architecture

The project uses Docker Compose with four services:
- `web`: Nginx server (port 8080 → 80)
- `app`: PHP-FPM application container
- `db`: MySQL 8.0 database (port 3306)
- `redis`: Redis key-value store (port 6379)

All containers are prefixed with `${PROJECT_NAME}` from environment variables.

**Important**: Laravel application code is in the `src/` directory, which is mounted into the containers.

## Common Commands

### Docker Operations

Start all services:
```bash
docker-compose up -d
```

Stop all services:
```bash
docker-compose down
```

Access the PHP application container:
```bash
docker-compose exec app sh
```

Access the database container:
```bash
docker-compose exec db mysql -u root -p
```

### Laravel Operations

All Laravel commands must be run **inside the app container** or prefixed with `docker-compose exec app`:

```bash
# Install PHP dependencies
docker-compose exec app composer install

# Run database migrations
docker-compose exec app php artisan migrate

# Create a new controller
docker-compose exec app php artisan make:controller ExampleController

# Create a new model
docker-compose exec app php artisan make:model ExampleModel

# Create a migration
docker-compose exec app php artisan make:migration create_example_table

# Clear application cache
docker-compose exec app php artisan cache:clear

# Generate application key (first-time setup)
docker-compose exec app php artisan key:generate

# Open Laravel Tinker REPL
docker-compose exec app php artisan tinker
```

### Testing

Run all tests:
```bash
docker-compose exec app php artisan test
```

Or using PHPUnit directly:
```bash
docker-compose exec app ./vendor/bin/phpunit
```

Run specific test suite:
```bash
docker-compose exec app php artisan test --testsuite=Feature
docker-compose exec app php artisan test --testsuite=Unit
```

Run a specific test file:
```bash
docker-compose exec app php artisan test tests/Feature/ExampleTest.php
```

### Frontend Operations

Frontend assets are managed with Vite. Run these commands **inside the app container**:

```bash
# Install npm dependencies
docker-compose exec app npm install

# Run development server (hot reload)
docker-compose exec app npm run dev

# Build for production
docker-compose exec app npm run build
```

### Code Quality

Format code with Laravel Pint:
```bash
docker-compose exec app ./vendor/bin/pint
```

## Project Structure

```
/
├── src/                    # Laravel application root
│   ├── app/               # Application logic
│   │   ├── Http/          # Controllers, Middleware, Kernel
│   │   ├── Models/        # Eloquent models
│   │   ├── Providers/     # Service providers
│   │   └── Exceptions/    # Exception handlers
│   ├── routes/            # Route definitions (web.php, api.php, etc.)
│   ├── database/          # Migrations, seeders, factories
│   ├── tests/             # Unit and Feature tests
│   ├── resources/         # Views, raw assets
│   ├── public/            # Web root, compiled assets
│   └── artisan            # Laravel CLI
├── php/                   # PHP Docker configuration
├── nginx/                 # Nginx configuration
├── mysql/                 # MySQL data and config
└── redis/                 # Redis data
```

## Environment Setup

1. Copy the environment file:
```bash
cp src/.env.example src/.env
```

2. Update `.env` for Docker services:
```
DB_HOST=db
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=<your_password>

REDIS_HOST=redis
```

3. Start Docker services and set up Laravel:
```bash
docker-compose up -d
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```

## Database

MySQL database files are persisted in `./mysql/data`.

Initialization scripts can be placed in `./mysql/init.d/` and will run on first container startup.

Access the application at http://localhost:8080

## Key Files

- `docker-compose.yml`: Service orchestration
- `php/Dockerfile`: PHP container build configuration
- `src/composer.json`: PHP dependencies (Laravel 9.19, Sanctum, Tinker)
- `src/package.json`: Frontend dependencies (Vite, Axios, Lodash)
- `src/.env.example`: Environment template
- `src/phpunit.xml`: PHPUnit test configuration
