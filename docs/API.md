# API Documentation

## Overview

This document describes the web routes available in the Laravel User Auth Blog application.

## Public Routes

### Home

```
GET /
Redirects to: /posts
```

### Blog Posts

```
GET /posts
Description: Display all published blog posts
View: posts.index
Pagination: Yes (12 per page)
```

```
GET /posts/{slug}
Description: Display a single post by slug
View: posts.show
Access: Public for published posts, author/admin/editor for drafts
```

---

## Authentication Routes

### Registration

```
GET /register
Description: Show registration form
View: auth.register
Middleware: guest
```

```
POST /register
Description: Process registration
Middleware: guest
Validation:
  - name: required|string|max:255
  - email: required|email|unique:users
  - password: required|confirmed|min:8
```

### Login

```
GET /login
Description: Show login form
View: auth.login
Middleware: guest
```

```
POST /login
Description: Process login
Middleware: guest
Validation:
  - email: required|email
  - password: required
Rate Limit: 5 attempts per minute
```

### Logout

```
POST /logout
Description: Log out current user
Middleware: auth
```

### Password Reset

```
GET /forgot-password
Description: Show forgot password form
View: auth.forgot-password
Middleware: guest
```

```
POST /forgot-password
Description: Send password reset link
Middleware: guest
```

```
GET /reset-password/{token}
Description: Show password reset form
View: auth.reset-password
Middleware: guest
```

```
POST /reset-password
Description: Process password reset
Middleware: guest
```

---

## Authenticated Routes

All routes below require authentication (`auth` middleware).

### Dashboard

```
GET /dashboard
Description: User dashboard with post management
View: dashboard
Controller: DashboardController
Access: All authenticated users
Features:
  - View own posts (users)
  - View all posts (admin/editor)
  - Statistics (total, published, drafts)
```

### Profile Management

```
GET /profile
Description: Edit profile page
View: profile.edit
```

```
PATCH /profile
Description: Update profile information
Validation:
  - name: required|string|max:255
  - email: required|email|unique:users (except current)
```

```
DELETE /profile
Description: Delete user account
Validation:
  - password: required|current_password
```

### Post Management

#### Create Post

```
GET /posts-create
Description: Show create post form
View: posts.create
Authorization: User must be authenticated
```

```
POST /posts
Description: Store new post
Authorization: Any authenticated user
Validation:
  - title: required|string|max:255
  - content: required|string
  - excerpt: nullable|string|max:500
  - is_published: boolean
Auto-generated:
  - slug: from title
  - excerpt: from content (if not provided)
  - author_id: current user
  - published_at: now() if is_published=true
```

#### Edit Post

```
GET /posts/{slug}/edit
Description: Show edit post form
View: posts.edit
Authorization: Post owner, editor, or admin
```

```
PATCH /posts/{slug}
Description: Update existing post
Authorization: Post owner, editor, or admin
Validation:
  - title: required|string|max:255
  - content: required|string
  - excerpt: nullable|string|max:500
  - is_published: boolean
```

#### Delete Post

```
DELETE /posts/{slug}
Description: Soft delete post
Authorization: Post owner, editor, or admin
```

---

## Authorization Rules

### Post Policies

| Action | User | Editor | Admin |
|--------|------|--------|-------|
| View published | ✅ | ✅ | ✅ |
| View own draft | ✅ | ✅ | ✅ |
| View others' draft | ❌ | ✅ | ✅ |
| Create | ✅ | ✅ | ✅ |
| Edit own | ✅ | ✅ | ✅ |
| Edit others' | ❌ | ✅ | ✅ |
| Delete own | ✅ | ✅ | ✅ |
| Delete others' | ❌ | ✅ | ✅ |
| Force delete | ❌ | ❌ | ✅ |

---

## Middleware

### Available Middleware

1. **auth**: Requires authentication
2. **guest**: Requires NOT authenticated
3. **role:admin,editor**: Requires specific role(s)
4. **throttle**: Rate limiting

### Custom Middleware

#### CheckRole

```php
Route::middleware(['auth', 'role:admin,editor'])->group(function () {
    // Admin and editor only routes
});
```

---

## Response Formats

### Success Response

```php
// Redirect with success message
return redirect()->route('posts.show', $post)
    ->with('success', 'Post created successfully!');
```

### Error Response

```php
// Validation error
return back()
    ->withErrors(['title' => 'The title field is required.'])
    ->withInput();

// Authorization error
abort(403, 'Forbidden - Insufficient permissions');
```

---

## Example API Calls

### Create a Post (Authenticated)

```http
POST /posts HTTP/1.1
Content-Type: application/x-www-form-urlencoded
Cookie: laravel_session=...

title=My+New+Post&content=This+is+the+content&is_published=1
```

### Update a Post (Authenticated)

```http
PATCH /posts/my-new-post HTTP/1.1
Content-Type: application/x-www-form-urlencoded
Cookie: laravel_session=...

_method=PATCH&title=Updated+Title&content=Updated+content
```

### Delete a Post (Authenticated)

```http
DELETE /posts/my-new-post HTTP/1.1
Cookie: laravel_session=...

_method=DELETE
```

---

## Rate Limiting

### Login Rate Limit

- **Limit**: 5 attempts per minute per email
- **Response**: 429 Too Many Requests
- **Cooldown**: Based on attempts

### Email Verification

- **Limit**: 6 requests per minute
- **Throttle key**: User ID

---

## CSRF Protection

All POST, PATCH, PUT, DELETE requests require CSRF token:

```blade
<form method="POST" action="/posts">
    @csrf
    <!-- form fields -->
</form>
```

```blade
<form method="POST" action="/posts/{{ $post->slug }}">
    @csrf
    @method('PATCH')
    <!-- form fields -->
</form>
```
