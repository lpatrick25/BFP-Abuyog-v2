<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# BFP Abuyog Laravel System

This is a Laravel-based system for the Bureau of Fire Protection (BFP) Abuyog. Follow these steps to set up and run the project locally.

## Prerequisites

- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL or compatible database
- Git

## Setup Instructions

### 1. Clone the Repository

```powershell
git clone git@github.com:lpatrick25/BFPAbuyog.git
cd BFPAbuyog
```

### 2. Install PHP Dependencies

```powershell
composer install
```

### 3. Install Node.js Dependencies

```powershell
npm install
```

### 4. Copy and Configure Environment File

```powershell
copy .env.example .env
```

Edit the `.env` file to match your local database and mail settings.

### 5. Generate Application Key

```powershell
php artisan key:generate
```

### 6. Run Migrations and Seeders

```powershell
php artisan migrate --seed
```

### 7. Link Storage (for file uploads)

```powershell
php artisan storage:link
```

### 8. Build Frontend Assets

```powershell
npm run build
```

### 9. Start the Development Server

```powershell
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000) in your browser.

---

## Additional Commands

- To run tests:
  ```powershell
  php artisan test
  ```
- To run the frontend in watch mode:
  ```powershell
  npm run dev
  ```

## Troubleshooting
- Ensure all prerequisites are installed and available in your PATH.
- If you encounter permission issues, try running your terminal as administrator.
- For any issues, check the Laravel [documentation](https://laravel.com/docs) or open an issue in this repository.

---

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
