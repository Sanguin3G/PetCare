# PetCare

PetCare is a Laravel application for a pet-care business. It combines an online product catalogue with service bookings, customer accounts, order management, and an administration area.

This repository is maintained by [Sanguin3G](https://github.com/Sanguin3G).

## What is included

- Customer registration, login, OTP flows, password reset, and profile management
- Product browsing, categories, cart, checkout, orders, vouchers, and comments
- Pet-care services and booking workflows
- Admin pages for products, categories, services, orders, users, staff, schedules, discounts, and vouchers
- JSON API endpoints protected with Laravel Passport/JWT middleware
- Email notifications and queued jobs
- VNPay payment integration hooks
- Vite-powered frontend assets with Bootstrap, Tailwind, Laravel Echo, and Pusher support

## Technology

- PHP 8.2+
- Laravel 11
- SQLite by default, with MySQL/PostgreSQL configuration available
- Laravel Passport, Sanctum, JWT Auth, Reverb, Redis/Predis, and Pusher integrations
- Vite and npm for frontend assets

## Local setup

### Requirements

- PHP 8.2 or newer with the extensions required by Laravel
- Composer
- Node.js 18+ and npm
- SQLite, or another database supported by Laravel

### Installation

```bash
git clone https://github.com/Sanguin3G/PetCare.git
cd PetCare

composer install
copy .env.example .env        # Windows
# cp .env.example .env        # macOS/Linux

php artisan key:generate
php artisan migrate --seed
php artisan storage:link

npm install
npm run build
php artisan serve
```

The application is then available at `http://localhost:8000`.

## Configuration

The default `.env.example` uses SQLite and log-based mail, which is suitable for local development. Update the following values when testing integrations:

- Database connection and credentials
- Mail transport and sender address
- VNPay credentials and callback URL
- Passport/JWT settings
- Pusher/Reverb and broadcasting settings

Never commit a real `.env` file, API key, payment credential, or private certificate.

## Useful commands

```bash
php artisan test
php artisan route:list
php artisan migrate:fresh --seed
npm run build
```

## License

This project is released under the MIT License. See [LICENSE](LICENSE).
