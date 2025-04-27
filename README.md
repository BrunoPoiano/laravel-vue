# Laravel Vue Challenge

A web application built with Laravel 10, Vue 3, and Inertia.js.

## 🔧 Technologies & Tools

- Laravel 10.x
- Vue.js 3.x
- Inertia.js
- TypeScript
- Tailwind CSS
- Vite
- Pinia (Vue Store)
- Lucide Icons

## 📋 Requirements

- PHP 8.1 or higher
- Node.js 16+ and npm
- Composer
- MySQL/PostgreSQL

## 🚀 Installation

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

## 🏃‍♂️ Development

1. Start the Laravel development server:
```bash
php artisan serve
```

2. Start the Vite development server:
```bash
npm run dev
```

## 🏗️ Building for Production

1. Build front-end assets:
```bash
npm run build
```

2. Configure production environment variables in `.env`

3. Optimize Laravel:
```bash
php artisan optimize
```

## 🎨 Code Style

This project uses Prettier for code formatting. The configuration can be found in `.prettierrc`.

Key formatting rules:
- Semi colons: enabled
- Single quotes: enabled
- Tab width: 4 spaces
- Print width: 150 characters
- Tailwind CSS class sorting: enabled

## 📦 Project Structure

- `/resources/js` - Vue components and application logic
- `/resources/css` - Stylesheets and Tailwind CSS configuration
- `/app` - Laravel PHP files
- `/routes` - API and web routes
- `/database` - Migrations and seeders

## 🔒 Security

Remember to:
- Set proper environment variables in production
- Keep dependencies updated
- Follow Laravel's security best practices
- Enable HTTPS in production

## 📝 License

[MIT License](LICENSE.md)
