# DeSchule Backend


> A DeSchule backend project.

## Features

- Laravel ^8

## Installation

- `composer install`
- Create a new file `.env` from `.env.example`
- Edit `.env` to set your database connection details and `APP_URL` (the url to your Laravel application)
- `php artisan key:generate` to generate APP key
- `php artisan jwt:secret` to generate JWT secret key
- `php artisan migrate` to run migrations
- `php artisan orchid:admin admin admin@admin.com password` to create admin user for admin panel
- `php artisan storage:link` to symlinks

## Usage

### Development

```bash
php artisan serve
```

You can access your application at `http://localhost:8000`.

### Queries structure
```sh
curl -X GET/POST/PATCH/DELETE \
  https://site.t/api/.../ \
  -H 'content-type: application/json' \
  -H 'authorization: Bearer {token}' \
  -d '{
    	"key": "value",
      }'
```

## Auth
```sh
Register POST /auth/register
Request
{
  "name": "User",
  "login": "user",
  "password": "password"
}

```
```sh
Login POST /auth/login
Request
{
  "login": "user",
  "password": "password"
}
```
```sh
Refresh token GET /auth/refresh-token
authorization: Bearer {token}
```
```sh
Logout GET /auth/logout
authorization: Bearer {token}
```
```sh
My profile GET /auth/me
authorization: Bearer {token}
```

## Users
```sh
Find all GET /users
authorization: Bearer {token}
```
```sh
Find one GET /users/:id
authorization: Bearer {token}
```
```sh
Update profile PATCH /users/:id
authorization: Bearer {token}
```
```sh
Remove DELETE /users/:id
authorization: Bearer {token}
```

## Packages
```sh
Find all GET /packages
Language: {locale}
Query params
{
  "type": "course/traffic",
}
```
```sh
Find one GET /packages/:id
```
