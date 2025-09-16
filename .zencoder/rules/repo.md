---
description: Repository Information Overview
alwaysApply: true
---

# Kaido Kit Information

## Summary
Kaido Kit is a powerful FilamentPHP starter kit designed to accelerate admin panel development. It provides a robust foundation with pre-configured plugins, configurations, and best practices for building feature-rich admin interfaces using Laravel and FilamentPHP.

## Structure
- **app/**: Core application code including models, controllers, and Filament resources
- **config/**: Configuration files for Laravel and installed packages
- **database/**: Database migrations, seeders, and factories
- **resources/**: Frontend assets, views, and components
- **routes/**: API and web route definitions
- **tests/**: PHPUnit and Pest test files

## Language & Runtime
**Language**: PHP
**Version**: 8.2+
**Framework**: Laravel 12.0
**Admin Panel**: Filament 3.2
**Build System**: Composer + npm
**Package Manager**: Composer (PHP), npm (JavaScript)

## Dependencies
**Main Dependencies**:
- filament/filament: ^3.2 (Admin panel framework)
- bezhansalleh/filament-shield: ^3.3 (RBAC)
- jeffgreco13/filament-breezy: ^2.4 (User profile management)
- filament/spatie-laravel-media-library-plugin: ^3.2 (Media management)
- filament/spatie-laravel-settings-plugin: ^3.2 (Settings management)
- rupadana/filament-api-service: ^3.4.4 (API support)
- dedoc/scramble: ^0.12.10 (API documentation)

**Development Dependencies**:
- laravel/sail: ^1.26 (Docker development environment)
- pestphp/pest: ^3.6 (Testing framework)
- laravel/pint: ^1.13 (PHP code style fixer)
- barryvdh/laravel-debugbar: ^3.14 (Debugging tool)

## Build & Installation
```bash
# Install dependencies
composer install
npm install

# Set up environment
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate --seed

# RBAC setup
php artisan shield:generate --all
php artisan shield:super-admin

# Start development server
composer run dev
```

## Docker
**Configuration**: Laravel Sail
**Services**:
- PHP 8.4 (Laravel application)
- MySQL 8.0 (Database)
- Redis (Cache/Queue)
**Run Command**:
```bash
./vendor/bin/sail up -d
```

## Testing
**Framework**: Pest/PHPUnit
**Test Location**: tests/ directory
**Configuration**: phpunit.xml
**Run Command**:
```bash
php artisan test
# or with Pest
./vendor/bin/pest
```

## Features
- Role-Based Access Control (RBAC) with Filament Shield
- Social login with Google via Filament Socialite
- User profile management with Filament Breezy
- 2-Factor Authentication
- Media management with Spatie Media Library
- API support with auto-generated documentation
- Dynamic settings management
- Export/Import functionality