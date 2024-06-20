# Kanye West Quotes App

This Laravel application fetches random Kanye West quotes from an external API and displays them. It includes user authentication, with registration and login endpoints, and allows authenticated users to refresh the displayed quotes.

## Prerequisites

- PHP >= 8.0
- Composer
- Laravel 9
- MySQL or SQLite
- Node.js & NPM (optional, for front-end dependencies)

## Setup Instructions

### Step 1: Clone the repository

```bash
git clone https://github.com/taufiq-cancode/kanyerest.git
cd kanyerest
```

### Step 2: Install dependencies

```bash
composer install
```

### Step 3: Set up environment variables

Copy the `.env.example` file to `.env` and modify it to match your local environment.

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### Step 4: Configure the database

Update the `.env` file with your database credentials. For example:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### Step 5: Run migrations

```bash
php artisan migrate
```

### Step 6: Install Laravel Breeze

Laravel Breeze is a simple implementation of Laravel's authentication features, including login, registration, and password reset.

1. Install Laravel Breeze:

```bash
composer require laravel/breeze --dev
```

2. Install Breeze:

```bash
php artisan breeze:install
```

3. Install front-end dependencies:

```bash
npm install
```

```bash
npm run dev
```

4. Run the migrations:

```bash
php artisan migrate
```

### Step 7: Running Tests
To run the PHPUnit tests included with Laravel, use the following command:

``` bash
php artisan test
```

This command will execute all tests located in the tests/ directory.

### Step 8: Serve the application

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`.

## Front-End

The front-end uses Laravel Breeze for authentication and Bootstrap for styling, along with jQuery for AJAX requests. These libraries are included via CDNs in the HTML file.

### Viewing Quotes

Navigate to `http://localhost:8000/quotes` after logging in. This will display a list of random Kanye West quotes.

### Refreshing Quotes

Click the "Refresh Quotes" button on the quotes page to fetch new quotes. This will make an AJAX `POST` request to `/quotes/refresh`.

## Using the API

The API endpoints require authentication using Laravel Sanctum. You must include the `Authorization` header with the Bearer token obtained from the login endpoint.

### API Endpoints

#### Register a User

**Endpoint:** `POST /register`

**Payload:**

```json
{
    "name": "John Doe",
    "email": "johndoe@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

#### Login

**Endpoint:** `POST /login`

**Payload:**

```json
{
    "email": "johndoe@example.com",
    "password": "password"
}
```

**Response:**

```json
{
    "access_token": "your_access_token_here",
    "token_type": "Bearer"
}
```

#### Get Random Quotes

**Endpoint:** `GET /api/quotes`

**Headers:**

```http
Authorization: Bearer your_access_token_here
```

**Response:**

```json
[
    "Quote 1",
    "Quote 2",
    "Quote 3",
    "Quote 4",
    "Quote 5"
]
```

#### Example Using Postman

To test the API directly on a already setup postman, visit `https://app.getpostman.com/join-team?invite_code=6c82a3436bbcc6b70c660ccb514f93e6&target_code=e92ff851cd5c83978d104fbe20dfd160`

Or

1. **Register**: Send a `POST` request to `http://localhost:8000/register` with the registration JSON payload.
2. **Login**: Send a `POST` request to `http://localhost:8000/login` with the login JSON payload. Copy the `access_token` from the response.
3. **Get Quotes**: Send a `GET` request to `http://localhost:8000/api/quotes` with the `Authorization` header set to `Bearer {access_token}`.

```http
GET /api/quotes HTTP/1.1
Host: localhost:8000
Authorization: Bearer your_access_token_here
```

### Example cURL Commands

#### Register

```bash
curl -X POST http://localhost:8000/register \
-H "Content-Type: application/json" \
-d '{
  "name": "John Doe",
  "email": "johndoe@example.com",
  "password": "password",
  "password_confirmation": "password"
}'
```

#### Login

```bash
curl -X POST http://localhost:8000/login \
-H "Content-Type: application/json" \
-d '{
  "email": "johndoe@example.com",
  "password": "password"
}'
```

#### Get Quotes

```bash
curl -X GET http://localhost:8000/api/quotes \
-H "Authorization: Bearer your_access_token_here"
```

### Protected Routes

The following routes are protected and require a valid `access_token`:

- `GET /api/quotes`: Fetch new quotes via API.

Ensure the `Authorization` header is included in your requests with the format:

```http
Authorization: Bearer your_access_token_here
```

## Additional Information

### Caching

The quotes are cached for 60 seconds using Laravel's caching system. You can adjust the caching duration by modifying the `Cache::remember` calls in the `QuoteController`.

### CSRF Protection

AJAX requests include a CSRF token for security. Ensure your `<meta name="csrf-token" content="{{ csrf_token() }}">` is present in the HTML and the `X-CSRF-TOKEN` header is included in AJAX requests.

## Troubleshooting

- Ensure your `.env` file is properly configured.
- Verify that the database migrations have been run.
- Check for any errors in the Laravel logs (`storage/logs/laravel.log`).


This README provides comprehensive setup and testing instructions, covering the key aspects of the Laravel application, including dependencies, environment configuration, database setup, authentication, and how to interact with the application and API endpoints.
