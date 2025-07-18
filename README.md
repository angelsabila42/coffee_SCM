# coffee_SCM
A Supply Management System for the GlobalBean Connect, coffee exporters

## Real-time Chat Setup

This application includes a real-time chat system powered by Pusher. For development:

### Option 1: Use Shared Development Credentials
The `.env.example` file includes shared development Pusher credentials that allow team members to chat with each other in real-time during development.

### Option 2: Create Your Own Pusher App
1. Sign up at [Pusher.com](https://pusher.com)
2. Create a new app
3. Copy your credentials to `.env`
4. Update `BROADCAST_DRIVER=pusher` in your `.env`

### Option 3: Disable Real-time Features
Set `BROADCAST_DRIVER=null` in your `.env` to disable real-time features.

**Note**: For production deployment, always use your own Pusher credentials for security.

[Instructions for Cloning the repository](https://www.bacancytechnology.com/qanda/laravel/clone-laravel-project-from-github)

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## How to Run This Project

1. **Clone the repository**  
   ```sh
   git clone <repository-url>
   cd coffee_SCM
   ```

2. **Install PHP dependencies**  
   ```sh
   composer install
   ```

3. **Install Node.js dependencies**  
   ```sh
   npm install
   ```

4. **Copy environment file and set up environment variables**  
   ```sh
   cp .env.example .env
   ```
   Edit `.env` as needed (database, etc).

5. **Generate application key**  
   ```sh
   php artisan key:generate
   ```

6. **Run database migrations**  
   ```sh
   php artisan migrate
   ```

7. **Start the development servers**  
   You can run both the backend and frontend together:
   ```sh
   composer run dev
   ```
   Or, run them separately in different terminals:
   - Start Laravel backend:  
     ```sh
     php artisan serve
     ```
   - Start Vite frontend:  
     ```sh
     npm run dev
     ```

8. **Access the application**  
   Open [http://localhost:8000](http://localhost:8000) in your browser.
