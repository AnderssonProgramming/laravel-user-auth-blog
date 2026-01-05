# 🚀 Setup Guide - Laravel User Auth Blog

## Prerequisites Installation

### Step 1: Install PHP 8.2+
1. Download PHP from: https://windows.php.net/download/
2. Extract to `C:\php`
3. Add `C:\php` to your PATH environment variable
4. Copy `php.ini-development` to `php.ini`
5. Enable required extensions in `php.ini`:
   ```ini
   extension=curl
   extension=fileinfo
   extension=mbstring
   extension=openssl
   extension=pdo_mysql
   extension=pdo_sqlite
   extension=sqlite3
   ```

### Step 2: Install Composer
1. Download from: https://getcomposer.org/download/
2. Run the installer
3. Verify installation: `composer --version`

### Step 3: Install Node.js (for Vite/frontend assets)
1. Download from: https://nodejs.org/
2. Install LTS version
3. Verify: `node --version` and `npm --version`

## Quick Start

Once prerequisites are installed, run:

```bash
# Install Laravel project
composer create-project laravel/laravel .

# Install dependencies
npm install

# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Start development server
php artisan serve
```

## Next Steps

After setup, the project will be scaffolded with authentication, roles, and blog functionality. Check the main README.md for features and usage.
