# Laravel Vue Challenge

A web application built with Laravel 10, Vue 3, and Inertia.js, demonstrating full-stack implementation patterns and best practices.

## Technologies & Tools

- Laravel 10.x
- Vue.js 3.x
- Inertia.js
- TypeScript
- Tailwind CSS
- Vite
- Pinia (Vue Store)
- Lucide Icons

## Requirements

- PHP 8.1 or higher
- Node.js 16+ and npm
- Composer
- MySQL/PostgreSQL

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd laravel-vue-challenge
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install NPM dependencies:
```bash
npm install
```

4. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database in `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations:
```bash
php artisan migrate
```

## Development

1. Start the Laravel development server:
```bash
php artisan serve
```

2. Start the Vite development server:
```bash
npm run dev
```

## Building for Production

1. Build front-end assets:
```bash
npm run build
```

2. Configure production environment variables in `.env`

3. Optimize Laravel:
```bash
php artisan optimize
```

3. Run tests:
```bash
php artisan test
```

## Architecture Overview

### Application Structure

The application follows a modular architecture with clear separation of concerns:

#### Backend (Laravel)

- **Controllers**: Handle HTTP requests and route to appropriate services
  - `app/Http/Controllers/` - Contains all controller classes organized by domain
  - Uses Form Request validation for input sanitization
  - Returns responses via Inertia or JSON for API endpoints

- **Services**: Contain business logic and database operations
  - `app/Services/` - Service classes implementing business rules
  - Interface-based design for better testability and maintenance
  - Handles caching and complex operations

- **Models**: Define database structure and relationships
  - `app/Models/` - Eloquent models with relationship definitions
  - Uses Laravel's trait system for behavior extension
  - Implements proper attribute casting and accessors/mutators

- **Resources**: Transform data for API responses
  - `app/Http/Resources/` - API resource classes for consistent response formatting
  - Handles data transformation and presentation logic

#### Frontend (Vue 3)

- **Components**: Reusable UI elements
  - `resources/js/components/` - Shared components
  - Uses Vue 3 Composition API for better code organization
  - TypeScript for type safety

- **Pages**: Main view components
  - `resources/js/pages/` - Inertia page components
  - Implements routing and state management
  - Handles user interactions and form submissions

- **Stores**: State management with Pinia
  - `resources/js/stores/` - Pinia store definitions
  - Centralized state management
  - Type-safe actions and mutations

- **Composables**: Reusable logic
  - `resources/js/composables/` - Shared business logic
  - Implements common functionality
  - Follows Vue 3 composition patterns

### Authentication Flow

1. User authentication handled via Laravel's built-in authentication
2. Sanctum used for API token authentication
3. Protected routes managed through middleware
4. Session-based auth for web routes

### Data Flow

1. Client Request → Laravel Router
2. Router → Controller
3. Controller → Service Layer
4. Service Layer → Model/Database
5. Response transformed via Resources
6. Inertia/API Response → Client

## API Documentation

### Authentication Endpoints

#### POST /login
- Description: Authenticate user and create session
- Request Body:
```json
{
  "email": "string",
  "password": "string"
}
```
- Response: 200 OK
```json
{
  "user": {
    "id": "number",
    "name": "string",
    "email": "string"
  }
}
```

#### POST /register
- Description: Create new user account
- Request Body:
```json
{
  "name": "string",
  "email": "string",
  "password": "string",
  "password_confirmation": "string"
}
```
- Response: 201 Created

### Product Endpoints

#### GET /products
- Description: List all products with pagination
- Authentication: Required
- Query Parameters:
  - search (string, optional): Filter products by name
  - per_page (number, optional): Items per page (default: 10)
  - current_page (number, optional): Page number
- Response: 200 OK
```json
{
  "data": [
    {
      "id": "number",
      "name": "string",
      "description": "string",
      "price": "number",
      "quantity": "number"
    }
  ],
  "meta": {
    "current_page": "number",
    "per_page": "number",
    "total": "number",
    "last_page": "number"
  }
}
```

#### POST /products
- Description: Create new product
- Authentication: Required
- Request Body:
```json
{
  "name": "string",
  "description": "string",
  "price": "number",
  "quantity": "number"
}
```
- Response: 201 Created

#### PUT /products/{id}
- Description: Update existing product
- Authentication: Required
- Parameters:
  - id (number): Product ID
- Request Body:
```json
{
  "name": "string",
  "description": "string",
  "price": "number",
  "quantity": "number"
}
```
- Response: 200 OK

#### DELETE /products/{id}
- Description: Delete product
- Authentication: Required
- Parameters:
  - id (number): Product ID
- Response: 204 No Content
