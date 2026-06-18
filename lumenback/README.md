# Lumen — Backend API

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<p align="center">
  <a href="https://github.com/Alinthropisc/Lumen/actions"><img src="https://github.com/Alinthropisc/Lumen/workflows/CI/badge.svg" alt="CI Status"></a>
  <img src="https://img.shields.io/badge/PHP-8.4-blue" alt="PHP 8.4">
  <img src="https://img.shields.io/badge/Laravel-13-red" alt="Laravel 13">
  <img src="https://img.shields.io/badge/license-MIT-green" alt="MIT License">
</p>

Lumen is the backend API for the Lumen platform — a full-stack monorepo project. Built with Laravel 13, it follows a clean **Service → Repository** architecture with contracts, events, jobs, observers, policies, and a CRUD scaffolding generator.

---

## Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 13 |
| Language | PHP 8.4 |
| Auth | Laravel Passport (OAuth2) |
| Permissions | Spatie Laravel Permission |
| API Docs | Dedoc Scramble |
| Queue | Redis / Sync |
| Cache | Redis |
| Telegram Bot | Nutgram |
| Performance | Laravel Octane |
| Testing | PHPUnit 12 |
| Code Style | Laravel Pint |

---

## Architecture

```
app/
├── Console/Commands/Generator/   # CRUD scaffolding generator
├── Contracts/                    # IBaseRepository, IBaseService
├── Dtos/                         # ApiResponse
├── Http/
│   ├── Controllers/              # Thin controllers — delegate to services
│   ├── Requests/                 # FormRequest validation
│   └── Resources/                # Eloquent API resources
├── Models/                       # BaseModel + domain models
├── Repositories/                 # BaseRepository + domain repos
├── Services/                     # BaseService + domain services
└── Traits/                       # RepositoryHelper, ServiceHelper
```

All domain entities follow the same layered pattern:
```
Controller → Service → Repository → Model
```

---

## Quick Start

```bash
git clone git@github.com:Alinthropisc/Lumen.git
cd Lumen

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan passport:install
```

Run the dev server:
```bash
composer run dev
```

---

## CRUD Generator

Generate a full API resource in one command:

```bash
php artisan generator:crud Post
```

This creates:
- `Controller`, `Service`, `Repository`
- `StoreRequest`, `UpdateRequest`, `Resource`
- `Model`, `Event`, `Job`, `Listener`, `Observer`, `Policy`
- `Factory`, `Seeder`
- `Feature` and `Unit` tests
- Migration

---

## Testing

```bash
php artisan test --compact
```

Tests use SQLite in-memory — no external services required.

---

## Code Style

```bash
vendor/bin/pint
```

CI automatically checks style on every push.

---

## API Documentation

Auto-generated via [Scramble](https://scramble.dedoc.co/):
```
GET /docs/api
```

---

## License

MIT
