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
Headers
- Authorization: Bearer {token}

```
```sh
Logout GET /auth/logout
Headers
- Authorization: Bearer {token}
```
```sh
My profile GET /auth/me
Headers
- Authorization: Bearer {token}
```

## Users
```sh
Find all GET /users
Headers
- Authorization: Bearer {token}
```
```sh
Find one GET /users/:id
Headers
- Authorization: Bearer {token}
```
```sh
Update profile PATCH /users/:id
Headers
- Authorization: Bearer {token}
```
```sh
Remove DELETE /users/:id
Headers
- Authorization: Bearer {token}
```

## Packages
```sh
Find all GET /packages
Headers
- Language: {locale}
Query params
{
  "type": "course/traffic",
}
```
```sh
Find one GET /packages/:id
```

## Payments
```sh
Find all GET /payments
Headers
- Authorization: Bearer {token}
```
```sh
Find one GET /payments/:id
Headers
- Authorization: Bearer {token}
```
```sh
Create POST /payments/:id
Headers
- Authorization: Bearer {token}
Request
{
  "package_id": 1,
  "amount": 100,
  "amount_type": "money" -> Optional, money or DT
  "pay_from": "card" -> Optional, card or apple_pay or google_pay, etc.
  "active_before": "2022-04-30 00:00:00"
}
```

## News
```sh
Find all GET /news
Headers
- Authorization: Bearer {token}
- Language: {locale}
```
```sh
Find one GET /news/:id
Headers
- Authorization: Bearer {token}
```

## Comments
```sh
Find all GET /comments
Headers
- Authorization: Bearer {token}
```
```sh
Find one GET /comments/:id
Headers
- Authorization: Bearer {token}
```
```sh
Create POST /comments/:id
Headers
- Authorization: Bearer {token}
Request
{
"news_id": 1,
"content": 'My comment',
"news_comment_id": 1 -> Optional, for reply
}
```

## Schedule
```sh
Find all GET /u/schedule
Headers
- Authorization: Bearer {token}
```
```sh
Find one GET /u/schedule/:id
Headers
- Authorization: Bearer {token}
```
```sh
Create POST /u/schedule
Headers
- Authorization: Bearer {token}
Request
{
"event_type_id": 1,
"title": 'Онлайн',
"date": "2022-05-30 00:00:00"
}
```

## Challenge
```sh
Find all GET /challenge
Headers
- Authorization: Bearer {token}
```
```sh
Find one GET /challenge/:id
Headers
- Authorization: Bearer {token}
```
```sh
Create POST /challenge
Headers
- Authorization: Bearer {token}
Request
{
"lesson_id": 1
}
```
