# DeSchule Backend


> A DeSchule backend project.

## Features

- Laravel ^8

## Installation

- `composer install`
- Create a new file `.env` from `.env.example`
- Edit `.env` to set your database connection details and `APP_URL` (the url to your Laravel application)
- `php artisan key:generate` to generate App key
- `php artisan migrate` to run migrations
- `php artisan orchid:admin admin admin@admin.com password` to create admin user for admin panel

## Usage

### Development

```bash
php artisan serve
```

You can access your application at `http://localhost:8000`.
