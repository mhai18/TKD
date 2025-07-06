# TKD Management System User Manual

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [System Requirements](#system-requirements)
- [Technology Stack](#technology-stack)
- [Installation Guide](#installation-guide)
- [Default Accounts](#default-accounts)
- [Usage Guide](#usage-guide)
- [Testing](#testing)
- [Contributing](#contributing)
- [Troubleshooting](#troubleshooting)
- [Laravel Sponsors](#laravel-sponsors)
- [Security Vulnerabilities](#security-vulnerabilities)
- [License](#license)

## Overview
The TKD Management System is a web-based application built with Laravel to streamline the management of Taekwondo organizations, tournaments, chapters, committees, coaches, and players. It offers role-based dashboards and functionalities tailored for administrators, tournament managers, coaches, players, and chairmen.

## Features
- **User Authentication and Authorization**: Role-based access for Admin, Chairman, Tournament Manager, Coach, and Player roles.
- **Organization Management**: Manage committees, chapters, and player registrations.
- **Tournament Management**: Create and manage Kyorugi tournaments, including match scheduling and bracket generation.
- **Event Categories**: Organize tournaments by categories (e.g., weight class, age group).
- **Reporting**: Export reports, schedules, and results as PDFs.
- **Address Management**: Handle location data (Province, Municipality, Barangay).
- **Profile Management**: Allow all user types to update their profiles.
- **Media Handling**: Upload and manage files using Spatie Media Library.
- **API Support**: Secure API authentication via Laravel Sanctum.

## System Requirements
- **Operating System**: Windows, macOS, or Linux
- **Web Server**: Apache or Nginx
- **PHP**: 8.1 or higher
- **Database**: MySQL 5.7+ or MariaDB 10.3+
- **Node.js**: 16.x or higher
- **npm**: 8.x or higher
- **Composer**: 2.x or higher
- **Memory**: Minimum 2GB RAM for development
- **Disk Space**: At least 1GB free space for installation and assets

## Technology Stack
- **Backend**: PHP 8.1+, Laravel 10+
- **Database**: MySQL
- **Frontend**: JavaScript, Bootstrap 5, jQuery
- **Asset Management**: Vite
- **File Uploads**: Spatie Media Library
- **API Authentication**: Laravel Sanctum

## Installation Guide

### Prerequisites
Ensure the following are installed:
- PHP 8.1 or higher
- Composer
- Node.js and npm
- MySQL or MariaDB
- Git

### Step-by-Step Installation
1. **Clone the Repository**
   ```sh
   git clone git@github.com:mhai18/TKD.git
   cd TKD
   ```

2. **Install PHP Dependencies**
   ```sh
   composer install
   ```

3. **Install Node Dependencies**
   ```sh
   npm install
   ```

4. **Configure Environment File**
   ```sh
   cp .env.example .env
   ```
   - Open `.env` in a text editor and configure:
     - Database credentials (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`)
     - Mail settings (e.g., `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, etc.)
     - App URL (`APP_URL`)

5. **Generate Application Key**
   ```sh
   php artisan key:generate
   ```

6. **Set Up Storage Permissions**
   ```sh
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

7. **Run Database Migrations and Seeders**
   ```sh
   php artisan migrate --seed
   ```

8. **Build Frontend Assets**
   - For production:
     ```sh
     npm run build
     ```
   - For development (with hot reloading):
     ```sh
     npm run dev
     ```

9. **Start the Development Server**
   ```sh
   php artisan serve
   ```
   - The application will be accessible at [http://localhost:8000](http://localhost:8000).

## Default Accounts
The database seeder creates the following accounts for testing:
- **Admin**: `admin@example.com` / Password: `admin123`
- **Chairman**: `chairman@example.com` / Password: (Check database or seeder file)
- **Tournament Manager**: `tm@example.com` / Password: (Check database or seeder file)
- **Coach**: `coach1@example.com`, `coach2@example.com` / Password: (Check database or seeder file)

To retrieve passwords, check the `DatabaseSeeder.php` file or query the database.

## Usage Guide
1. **Accessing the Application**
   - Open [http://localhost:8000](http://localhost:8000) in your browser after starting the server.
   - Log in using one of the default accounts or register a new user (if enabled).

2. **Role-Based Dashboards**
   - **Admin**: Access the admin dashboard to manage committees, chapters, users, and view system-wide reports.
   - **Chairman**: Oversee organizational activities, approve tournaments, and manage chapters.
   - **Tournament Manager**: Create tournaments, manage matches, schedules, and export PDF reports.
   - **Coach**: Register players, manage player profiles, and view assigned tournaments.
   - **Player**: View tournament schedules, results, and update personal profiles.

3. **Navigation**
   - Use the sidebar to access role-specific features.
   - Common actions include creating tournaments, adding players, or generating reports.

4. **Key Features**
   - **Tournament Creation**: Tournament Managers can create events, set categories, and assign players.
   - **Match Scheduling**: Automatically generate brackets or manually schedule matches.
   - **PDF Exports**: Download schedules, results, or player lists as PDFs from the respective dashboards.
   - **Profile Management**: Update user details via the profile section.

## Testing
Run the test suite to verify application functionality:
```sh
php artisan test
```
- Ensure the database is properly configured in `.env.testing` for testing.
- Tests cover authentication, CRUD operations, and API endpoints.

## Contributing
To contribute to the TKD Management System:
1. Fork the repository.
2. Create a feature branch (`git checkout -b feature/your-feature`).
3. Commit your changes (`git commit -m "Add your feature"`).
4. Push to the branch (`git push origin feature/your-feature`).
5. Submit a pull request with a detailed description of your changes.

Refer to the [Laravel contribution guide](https://laravel.com/docs/contributions) for more details.

## Troubleshooting
- **Database Connection Issues**: Verify `.env` database credentials match your MySQL setup.
- **Migration Errors**: Run `php artisan migrate:fresh --seed` to reset and reseed the database.
- **Asset Compilation Issues**: Ensure Node.js and npm are installed, then rerun `npm install` and `npm run build`.
- **Error Logs**: Check `storage/logs/laravel.log` for detailed error messages.
- **Permission Issues**: Ensure `storage` and `bootstrap/cache` directories have proper permissions (`775`).

## Laravel Sponsors
We thank the following sponsors for funding Laravel development. To become a sponsor, visit the [Laravel Patreon page](https://patreon.com/taylorotwell).

### Premium Partners
- [Vehikl](https://vehikl.com/)
- [Tighten Co.](https://tighten.co)
- [Kirschbaum Development Group](https://kirschbaumdevelopment.com)
- [64 Robots](https://64robots.com)
- [Cubet Techno Labs](https://cubettech.com)
- [Cyber-Duck](https://cyber-duck.co.uk)
- [Many](https://www.many.co.uk)
- [Webdock, Fast VPS Hosting](https://www.webdock.io/en)
- [DevSquad](https://devsquad.com)
- [Curotec](https://www.curotec.com/services/technologies/laravel/)
- [OP.GG](https://op.gg)
- [WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)
- [Lendio](https://lendio.com)

## Security Vulnerabilities
If you discover a security vulnerability, please email Taylor Otwell at [taylor@laravel.com](mailto:taylor@laravel.com). All vulnerabilities will be addressed promptly.

## License
The TKD Management System is built on the Laravel framework, which is open-sourced under the [MIT License](https://opensource.org/licenses/MIT).
