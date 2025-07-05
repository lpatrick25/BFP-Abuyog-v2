<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 🔥 BFP Abuyog Laravel System – User Manual

This is a Laravel-based web application developed for the **Bureau of Fire Protection (BFP) – Abuyog**, designed to manage fire safety inspections, establishment mapping, user roles, and application processing in a centralized and efficient manner.

---

## 🛠️ Prerequisites

Ensure the following are installed on your system:

* PHP ≥ 8.1
* Composer
* Node.js and npm
* MySQL or compatible database
* Git
* Laravel CLI (optional, but recommended)

---

## ⚙️ Setup Instructions

### 1. Clone the Repository or Use Project Zip File

You can either clone the repository from GitHub or use the attached project zip file (`BFP-Abuyog-v2.zip`) to set up the project.

#### Option 1: Clone the Repository
Clone the repository using either SSH or HTTPS:

```bash
# Using SSH
git clone git@github.com:lpatrick25/BFP-Abuyog-v2.git
# Or using HTTPS
git clone https://github.com/lpatrick25/BFP-Abuyog-v2.git
cd BFP-Abuyog-v2
```

#### Option 2: Use the Attached Project Zip File
If you have the project zip file (`BFP-Abuyog-v2.zip`), extract it to your desired directory:

```bash
unzip BFP-Abuyog-v2.zip
cd BFP-Abuyog-v2
```

**Explanation**: Cloning the repository directly from GitHub ensures you have the latest version of the project and allows for easy updates using Git. Alternatively, the attached zip file provides a snapshot of the project, which is useful if you prefer working offline or do not have Git installed. Both methods provide the same project files, so choose the one that best suits your workflow.

### 2. Install Backend Dependencies

```bash
composer install
```

### 3. Install Frontend Dependencies

```bash
npm install
```

### 4. Configure Environment File

```bash
cp .env.example .env
```

Then, update your `.env` with the correct **database**, **mail**, and **APP_URL** values.

### 5. Generate App Key

```bash
php artisan key:generate
```

### 6. Run Migrations and Seeders

```bash
php artisan migrate --seed
```

### 7. Link Storage for Uploads

```bash
php artisan storage:link
```

### 8. Build Frontend Assets

```bash
npm run build
```

### 9. Start the Development Server

```bash
php artisan serve
```

Visit the app at: [http://localhost:8000](http://localhost:8000)

---

# Project Structure

This document describes the main folders and files in the project.

## Root Directory

- `artisan` - Laravel's command-line interface.
- `composer.json` / `composer.lock` - PHP dependencies and lock file.
- `package.json` - Node.js dependencies.
- `phpunit.xml` - PHPUnit configuration.
- `README.md` - Project documentation.
- `vite.config.js` - Vite build tool configuration.

## Main Folders

- `app/` - Application core code (Controllers, Models, Mail, Notifications, etc.)
  - `Console/` - Artisan commands.
  - `Events/` - Event classes.
  - `Exceptions/` - Exception handling.
  - `Http/` - Controllers, Middleware, Requests, Resources.
  - `Mail/` - Mailable classes.
  - `Models/` - Eloquent models.
  - `Notifications/` - Notification classes.
  - `Observers/` - Model observers.
  - `Providers/` - Service providers.
  - `Services/` - Custom services.
  - `Traits/` - Reusable traits.

- `bootstrap/` - Application bootstrap files.
- `config/` - Configuration files.
- `database/` - Database migrations, seeders, and factories.
- `public/` - Publicly accessible files (index.php, assets, uploads).
- `resources/` - Views, raw assets (CSS, JS).
- `routes/` - Route definitions (`web.php`, `api.php`, etc.).
- `storage/` - Logs, cache, compiled files, user uploads.
- `tests/` - Test cases (Feature, Unit).
- `vendor/` - Composer dependencies.

---

## 🔐 Authentication

### Guest Routes:

* `/signin` – Login page
* `/signup` – Registration page
* `/recover` – Forgot password
* `/password/reset/{token}` – Reset password page

### Email Verification

The system supports email verification through signed URLs and includes notification support.

---

## 👥 User Roles and Routes

### 🔸 Admin

**Dashboard:** `/admin/dashboard`
Can manage:

* Clients
* Marshalls
* Inspectors
* Users
* Mapping
* Establishment Profiles
  Includes token generation and session routing.

---

### 🔸 Client

**Dashboard:** `/client/dashboard`
Can:

* Register Establishments
* Submit Applications
* Track Schedules & FSICs
* Generate Session Tokens
* Map Establishments
* View and Edit Submissions

---

### 🔸 Marshall

**Dashboard:** `/marshall/dashboard`
Can:

* View Applicant List & Establishments
* Handle Schedules and FSIC lists
* Generate Reports (Compliance, Audit, Statistical, etc.)

---

### 🔸 Inspector

**Dashboard:** `/inspector/dashboard`
Can:

* View Schedules and Assignments
* View Establishment Locations
* Generate Session Tokens

---

## 🗺️ Public Access Routes

* `/` – Home
* `/e-FSIC/{fsicNo?}` – View FSIC by number
* `/fsic_no/{fsicNo}` – Decrypt and redirect to FSIC

---

## 📍 Map & Push Notification Features

* View Map: `/load-map-view`
* Store Push Subscription: `/store-subscription`
* Search FSIC: `/search-FSIC`

---

## 🔄 Resource Controllers

These are automatically mapped using `Route::resources()`:

* Clients
* Marshalls
* Inspectors
* Users
* Establishments
* Applications
* Application Status
* Schedules
* FSICs

---

## 🧪 Additional Commands

```bash
# Run Laravel feature & unit tests
php artisan test

# Start Vite dev server for live-reloading assets
npm run dev
```

---

## 🧯 Troubleshooting

| Problem                    | Solution                                            |
| -------------------------- | --------------------------------------------------- |
| `.env` file missing        | Copy `.env.example` to `.env`                       |
| Migrations failing         | Check DB config and run `php artisan migrate:fresh` |
| Storage files missing      | Run `php artisan storage:link`                      |
| Styles/scripts not working | Re-run `npm install && npm run build`               |

---

## 📬 Support

* Maintained by: `Patrick Y. Leoncito` (Developer)
* Contributor: `John Rey P. Doromal and Roenamae B. Turtosa`
* Email: `patrickleoncito25@gmail.com`
* Laravel Docs: [https://laravel.com/docs](https://laravel.com/docs)

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
