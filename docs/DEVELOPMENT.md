# Development Guide

## Quick Start Commands

### Initial Setup

```bash
# Clone the repository
git clone https://github.com/AnderssonProgramming/laravel-user-auth-blog.git
cd laravel-user-auth-blog

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
touch database/database.sqlite
php artisan migrate
php artisan db:seed
```

### Development Workflow

```bash
# Start development server
php artisan serve

# Start Vite dev server (in another terminal)
npm run dev

# Access the application
# http://localhost:8000
```

---

## Useful Artisan Commands

### Database Management

```bash
# Fresh migration (drop all tables and re-run)
php artisan migrate:fresh

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Rollback last migration
php artisan migrate:rollback

# Check migration status
php artisan migrate:status

# Seed database
php artisan db:seed

# Seed specific seeder
php artisan db:seed --class=RoleSeeder
```

### Tinker (Interactive Shell)

```bash
# Open Tinker
php artisan tinker

# Example commands in Tinker:
>>> User::count()
>>> Post::where('is_published', true)->count()
>>> $user = User::first()
>>> $user->posts
>>> Post::factory()->count(5)->create()
```

### Cache Management

```bash
# Clear all caches
php artisan optimize:clear

# Clear specific caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cache optimization (production)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Testing

```bash
# Run all tests
php artisan test

# Run tests with coverage
php artisan test --coverage

# Run specific test
php artisan test --filter PostTest

# Run specific test method
php artisan test --filter test_user_can_create_post
```

### Code Quality

```bash
# Format code with Laravel Pint
./vendor/bin/pint

# Check code style without fixing
./vendor/bin/pint --test

# Format specific file
./vendor/bin/pint app/Models/User.php
```

---

## Common Development Tasks

### Creating New Users Manually

```php
// In Tinker (php artisan tinker)
$role = Role::where('name', 'user')->first();

User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => Hash::make('password'),
    'role_id' => $role->id,
    'email_verified_at' => now(),
]);
```

### Creating New Posts

```php
// In Tinker
$user = User::first();

Post::create([
    'title' => 'My New Post',
    'content' => 'This is the post content...',
    'author_id' => $user->id,
    'is_published' => true,
    'published_at' => now(),
]);
```

### Changing User Role

```php
// In Tinker
$user = User::where('email', 'user@example.com')->first();
$adminRole = Role::where('name', 'admin')->first();
$user->update(['role_id' => $adminRole->id]);
```

### Soft Delete Recovery

```php
// In Tinker
// Get soft-deleted posts
Post::onlyTrashed()->get()

// Restore a soft-deleted post
$post = Post::onlyTrashed()->first();
$post->restore();

// Permanently delete
$post->forceDelete();
```

---

## Frontend Development

### Asset Compilation

```bash
# Development mode (watch for changes)
npm run dev

# Production build
npm run build

# Preview production build
npm run preview
```

### Tailwind CSS

```bash
# Add custom classes in resources/css/app.css

# Tailwind utilities are available in Blade templates:
<div class="bg-blue-500 text-white p-4 rounded-lg">
    Custom styled content
</div>
```

---

## Debugging

### Laravel Debugbar (Optional)

```bash
# Install debugbar
composer require barryvdh/laravel-debugbar --dev

# It will auto-register in development
```

### Logs

```bash
# View logs
tail -f storage/logs/laravel.log

# Clear logs (Windows)
del storage\logs\laravel.log

# Clear logs (Unix)
rm storage/logs/laravel.log
```

### Query Debugging

```php
// In your code, enable query log:
DB::enableQueryLog();

// Your queries here
$posts = Post::with('author')->get();

// Dump queries
dd(DB::getQueryLog());
```

---

## Database Queries

### Common Eloquent Queries

```php
// Get published posts with authors
Post::with('author')->published()->latest('published_at')->paginate(10);

// Get user's posts
$user->posts()->orderBy('created_at', 'desc')->get();

// Get admins
User::whereHas('role', fn($q) => $q->where('name', 'admin'))->get();

// Count posts by user
User::withCount('posts')->get();

// Search posts
Post::where('title', 'like', '%search%')
    ->orWhere('content', 'like', '%search%')
    ->published()
    ->get();
```

---

## Production Deployment Checklist

### Before Deployment

- [ ] Run tests: `php artisan test`
- [ ] Build assets: `npm run build`
- [ ] Review `.env` settings
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate production key if needed
- [ ] Configure production database
- [ ] Set proper file permissions

### Deployment Commands

```bash
# Pull latest code
git pull origin main

# Install/update dependencies
composer install --optimize-autoloader --no-dev
npm ci

# Migrate database
php artisan migrate --force

# Build assets
npm run build

# Clear and cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart queue workers if using
php artisan queue:restart
```

### File Permissions (Linux)

```bash
sudo chown -R www-data:www-data /path/to/project
sudo chmod -R 755 /path/to/project
sudo chmod -R 775 storage bootstrap/cache
```

---

## Troubleshooting

### Common Issues

#### "Class not found"
```bash
composer dump-autoload
```

#### Permission errors
```bash
# Windows
# Run as Administrator or check folder permissions

# Linux/Mac
chmod -R 775 storage bootstrap/cache
```

#### Node/NPM errors
```bash
# Clear node_modules and reinstall
rm -rf node_modules package-lock.json
npm install
```

#### Database issues
```bash
# Reset database
php artisan migrate:fresh --seed
```

---

## Environment Variables

### Essential Variables

```env
APP_NAME="User Auth Blog"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
# or for MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

MAIL_MAILER=log
# or configure real mail:
# MAIL_MAILER=smtp
# MAIL_HOST=smtp.gmail.com
# MAIL_PORT=587
# MAIL_USERNAME=your-email@gmail.com
# MAIL_PASSWORD=your-password
# MAIL_ENCRYPTION=tls
```

---

## Git Workflow

### Feature Development

```bash
# Create feature branch
git checkout -b feature/my-feature

# Make changes and commit
git add .
git commit -m "feat: add my feature"

# Push to remote
git push origin feature/my-feature

# Create pull request on GitHub
```

### Commit Message Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

**Types:** feat, fix, docs, style, refactor, test, chore

---

## Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)

---

## Need Help?

- Check existing [GitHub Issues](https://github.com/AnderssonProgramming/laravel-user-auth-blog/issues)
- Create a new issue with detailed information
- Review the [Contributing Guide](CONTRIBUTING.md)
