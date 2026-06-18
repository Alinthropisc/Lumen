# Lumen — Full-Stack Monorepo

> Production-ready monorepo with a Laravel API backend, Next.js web frontend, Telegram Mini App, and Flutter mobile app — all sharing types and a common design system.

[![CI — lumenback](https://github.com/Alinthropisc/Lumen/actions/workflows/ci.yml/badge.svg)](https://github.com/Alinthropisc/Lumen/actions/workflows/ci.yml)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

## Structure

```
lumen/
├── lumenback/     # Laravel 13 + Passport + Spatie Roles
├── lumenfront/    # Next.js 15 + React 19 + Tailwind
├── lumenmini/     # Vite + React (Telegram Mini App)
├── lumenmobile/   # Flutter 3
├── packages/
│   ├── @lumen/types   # Shared TypeScript types
│   ├── @lumen/ui      # Shared React component library
│   └── @lumen/config  # Shared ESLint + TypeScript config
└── docker-compose.yml # PostgreSQL + Redis
```

## Quick Start

```bash
# Install JS dependencies
npm install

# Start infrastructure (PostgreSQL + Redis)
make docker-up

# Backend
cd lumenback
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan passport:install
php artisan serve

# Frontend
cd lumenfront && npm run dev

# Mini App
cd lumenmini && npm run dev

# Mobile
cd lumenmobile && flutter run
```

## Backend API

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/auth/send-code` | Send verification code |
| POST | `/api/auth/login` | Login |
| POST | `/api/auth/register` | Register |
| POST | `/api/auth/reset-password` | Reset password |
| POST | `/api/auth/logout` | Logout |
| GET | `/api/users` | List users |
| POST | `/api/users` | Create user |
| GET | `/api/users/{id}` | Show user |
| PUT | `/api/users/{id}` | Update user |
| DELETE | `/api/users/{id}` | Delete user |

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 13, PHP 8.4, PostgreSQL, Redis |
| Auth | Laravel Passport (OAuth2), Spatie Roles |
| Frontend | Next.js 15, React 19, Tailwind CSS 4 |
| Mini App | Vite, React, TWA SDK |
| Mobile | Flutter 3, BLoC, GoRouter |
| Shared | TypeScript, Zod, Axios, React Query |
