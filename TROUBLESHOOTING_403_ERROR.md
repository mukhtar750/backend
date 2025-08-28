# BDSP Training Module 403 Error Troubleshooting Guide

## Overview
This guide helps resolve the 403 Forbidden error occurring with BDSP training module functionality on your production server (Namecheap hosting).

## Quick Diagnosis Steps

### Step 1: Run the Debug Script
```bash
cd /path/to/your/laravel/project
php debug_403_issue.php
```

This script will check:
- Database connectivity
- User role data integrity
- Middleware registration
- Policy authorization logic
- Route configuration

### Step 2: Check Server Error Logs

**For Namecheap cPanel hosting:**
1. Login to your cPanel
2. Go to "Error Logs" in the Files section
3. Look for recent 403 errors with timestamps matching your test attempts
4. Check both Apache error logs and Laravel logs

**Laravel logs location:**
```
storage/logs/laravel.log
```

### Step 3: Verify Database Configuration

Check your production `.env` file:
```bash
cat .env | grep DB_
```

Ensure these match your Namecheap database settings:
- `DB_CONNECTION=mysql`
- `DB_HOST` (usually localhost or your database server)
- `DB_DATABASE` (your database name)
- `DB_USERNAME` (your database username)
- `DB_PASSWORD` (your database password)

## Common Causes and Solutions

### 1. Role Data Inconsistency

**Problem:** User role field contains unexpected values or case differences.

**Check:**
```sql
SELECT id, name, email, role, is_approved FROM users WHERE role LIKE '%bdsp%';
```

**Solution:**
```sql
-- Fix role case if needed
UPDATE users SET role = 'bdsp' WHERE role = 'BDSP';

-- Ensure user is approved
UPDATE users SET is_approved = 1 WHERE role = 'bdsp' AND id = YOUR_USER_ID;
```

### 2. Missing or Incorrect Middleware Registration

**Check:** Verify `app/Http/Kernel.php` contains:
```php
protected $routeMiddleware = [
    // ... other middleware
    'role' => \App\Http\Middleware\RoleMiddleware::class,
];
```

**Solution:** If missing, add the middleware registration and redeploy.

### 3. Database Connection Issues

**Symptoms:** 
- User authentication works but authorization fails
- Inconsistent behavior

**Check:**
```bash
php artisan tinker
>>> \App\Models\User::count()
>>> \App\Models\TrainingModule::count()
```

**Solution:**
- Verify database credentials in `.env`
- Check database server accessibility
- Ensure database exists and has correct permissions

### 4. Cache Issues

**Problem:** Cached configuration or routes causing issues.

**Solution:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
```

### 5. File Permissions

**Problem:** Laravel cannot write to storage or bootstrap/cache directories.

**Check:**
```bash
ls -la storage/
ls -la bootstrap/cache/
```

**Solution:**
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chown -R www-data:www-data storage/ bootstrap/cache/
```

### 6. Server-Level Restrictions

**Problem:** Apache/Nginx configuration blocking requests.

**Check `.htaccess` file:**
```apache
# Ensure this exists in public/.htaccess
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]
```

### 7. Environment Configuration

**Check production environment:**
```bash
php artisan env
```

**Ensure:**
- `APP_ENV=production`
- `APP_DEBUG=false` (for production)
- `APP_KEY` is set

## Step-by-Step Debugging Process

### 1. Enable Debug Mode Temporarily

In your production `.env`:
```
APP_DEBUG=true
LOG_LEVEL=debug
```

**⚠️ Remember to disable debug mode after troubleshooting!**

### 2. Test Specific Functionality

**Test user authentication:**
```bash
php artisan tinker
>>> $user = \App\Models\User::where('email', 'your-bdsp-email@example.com')->first();
>>> $user->role
>>> $user->is_approved
```

**Test policy authorization:**
```bash
php artisan tinker
>>> $user = \App\Models\User::where('role', 'bdsp')->first();
>>> $policy = new \App\Policies\TrainingModulePolicy();
>>> $policy->create($user)
>>> $policy->viewAny($user)
```

### 3. Check Route Middleware

```bash
php artisan route:list | grep training-modules
```

Ensure BDSP routes have `auth,role:bdsp` middleware.

### 4. Monitor Real-Time Logs

```bash
tail -f storage/logs/laravel.log
```

Then attempt the failing action and watch for error messages.

## Production-Specific Considerations

### Namecheap Hosting Specifics

1. **Database Host:** Often `localhost` or specific server name
2. **File Permissions:** May need to be set via cPanel File Manager
3. **PHP Version:** Ensure compatible PHP version (8.1+ recommended)
4. **Memory Limits:** Check if sufficient for Laravel application

### Security Considerations

1. **SSL Certificate:** Ensure HTTPS is properly configured
2. **Firewall Rules:** Check if any IP restrictions are in place
3. **Rate Limiting:** Verify no rate limits are blocking requests

## Final Checklist

- [ ] Database connection working
- [ ] User has correct role ('bdsp')
- [ ] User is approved (`is_approved = 1`)
- [ ] Middleware properly registered
- [ ] Routes have correct middleware
- [ ] File permissions are correct
- [ ] Caches are cleared
- [ ] Error logs checked
- [ ] Debug script results reviewed

## Getting Additional Help

If the issue persists:

1. **Collect Information:**
   - Debug script output
   - Error log entries
   - Database query results
   - Server configuration details

2. **Contact Support:**
   - Namecheap technical support for server-level issues
   - Laravel community forums for application-level issues

3. **Temporary Workaround:**
   - Create a simple test route to isolate the issue
   - Use Laravel's built-in authentication scaffolding for comparison

---

**Remember:** Always backup your database and files before making changes to production!