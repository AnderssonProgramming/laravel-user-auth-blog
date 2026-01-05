# Database Documentation

## Overview

This document describes the database schema for the Laravel User Auth Blog application.

## Tables

### roles

Stores user role definitions.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| name | VARCHAR(255) | UNIQUE, NOT NULL | Role name (admin, editor, user) |
| description | TEXT | NULLABLE | Role description |
| created_at | TIMESTAMP | NULLABLE | Creation timestamp |
| updated_at | TIMESTAMP | NULLABLE | Last update timestamp |

**Indexes:**
- PRIMARY: id
- UNIQUE: name

---

### users

Stores user account information.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| name | VARCHAR(255) | NOT NULL | User's full name |
| email | VARCHAR(255) | UNIQUE, NOT NULL | User's email address |
| email_verified_at | TIMESTAMP | NULLABLE | Email verification timestamp |
| password | VARCHAR(255) | NOT NULL | Hashed password |
| role_id | BIGINT | FOREIGN KEY, NULLABLE | Reference to roles.id |
| remember_token | VARCHAR(100) | NULLABLE | Remember me token |
| created_at | TIMESTAMP | NULLABLE | Account creation timestamp |
| updated_at | TIMESTAMP | NULLABLE | Last update timestamp |

**Indexes:**
- PRIMARY: id
- UNIQUE: email
- FOREIGN KEY: role_id REFERENCES roles(id) ON DELETE SET NULL

---

### posts

Stores blog post content and metadata.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| title | VARCHAR(255) | NOT NULL | Post title |
| slug | VARCHAR(255) | UNIQUE, NOT NULL | URL-friendly identifier |
| excerpt | TEXT | NULLABLE | Short description |
| content | LONGTEXT | NOT NULL | Full post content |
| author_id | BIGINT | FOREIGN KEY, NOT NULL | Reference to users.id |
| is_published | BOOLEAN | DEFAULT FALSE | Publication status |
| published_at | TIMESTAMP | NULLABLE | Publication timestamp |
| created_at | TIMESTAMP | NULLABLE | Creation timestamp |
| updated_at | TIMESTAMP | NULLABLE | Last update timestamp |
| deleted_at | TIMESTAMP | NULLABLE | Soft delete timestamp |

**Indexes:**
- PRIMARY: id
- UNIQUE: slug
- INDEX: author_id
- INDEX: (is_published, published_at)

**Soft Deletes:** Yes (deleted_at column)

---

### password_reset_tokens

Stores password reset tokens.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| email | VARCHAR(255) | PRIMARY KEY | User's email address |
| token | VARCHAR(255) | NOT NULL | Reset token |
| created_at | TIMESTAMP | NULLABLE | Token creation timestamp |

---

### sessions

Stores user session data.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | VARCHAR(255) | PRIMARY KEY | Session identifier |
| user_id | BIGINT | NULLABLE, INDEX | Reference to users.id |
| ip_address | VARCHAR(45) | NULLABLE | User's IP address |
| user_agent | TEXT | NULLABLE | Browser user agent |
| payload | LONGTEXT | NOT NULL | Session data |
| last_activity | INTEGER | INDEX | Last activity timestamp |

---

## Relationships

### One-to-Many

1. **Role → Users**
   - A role can have many users
   - A user belongs to one role
   - Relationship: `Role::hasMany(User::class)` / `User::belongsTo(Role::class)`

2. **User → Posts**
   - A user (author) can have many posts
   - A post belongs to one user (author)
   - Relationship: `User::hasMany(Post::class, 'author_id')` / `Post::belongsTo(User::class, 'author_id')`

---

## Migrations Order

Migrations must run in this order due to foreign key dependencies:

1. `2024_01_01_000001_create_roles_table.php`
2. `2024_01_01_000002_create_users_table.php`
3. `2024_01_01_000003_create_cache_table.php`
4. `2024_01_01_000004_create_jobs_table.php`
5. `2024_01_01_100000_create_posts_table.php`

---

## Default Data (Seeders)

### Roles

- **admin**: Administrator with full access
- **editor**: Editor who can manage all posts
- **user**: Regular user who can manage own posts

### Sample Users (Development)

- admin@example.com (password: password) - Admin role
- editor@example.com (password: password) - Editor role
- user@example.com (password: password) - User role
- 10 random users with User role

### Sample Posts

- 20 published posts
- 10 draft posts

---

## Query Examples

### Get all published posts with authors

```php
Post::with('author')
    ->published()
    ->latest('published_at')
    ->get();
```

### Get user's posts

```php
$user->posts()
    ->orderBy('created_at', 'desc')
    ->get();
```

### Get users by role

```php
User::whereHas('role', function($query) {
    $query->where('name', 'admin');
})->get();
```

### Create a new post

```php
Post::create([
    'title' => 'My Post',
    'content' => 'Post content...',
    'author_id' => auth()->id(),
    'is_published' => true,
    'published_at' => now(),
]);
```

---

## Database Optimization

### Indexes

All foreign keys have indexes for optimal query performance.

Additional composite indexes:
- `posts(is_published, published_at)` - For efficient published post queries

### Soft Deletes

Posts use soft deletes to allow recovery:
- Deleted posts remain in database with `deleted_at` timestamp
- Queries automatically exclude soft-deleted records
- Can be permanently deleted or restored

---

## Backup & Maintenance

### Backup Commands

```bash
# SQLite backup
cp database/database.sqlite database/backups/database_$(date +%Y%m%d).sqlite

# MySQL backup
mysqldump -u username -p database_name > backup.sql
```

### Maintenance Commands

```bash
# Clear old soft-deleted posts (30 days+)
php artisan tinker
>>> Post::onlyTrashed()->where('deleted_at', '<', now()->subDays(30))->forceDelete();

# Optimize database
php artisan optimize
```
