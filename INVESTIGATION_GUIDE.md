# 403 Error Investigation Guide

This guide provides a systematic approach to investigate and resolve the 403 Forbidden error in your Laravel application.

## Phase 1: Initial Assessment

### Step 1: Run Comprehensive Investigation Script
```bash
php investigate_403_comprehensive.php
```

This script will check:
- Laravel environment configuration
- Database connectivity
- User roles and permissions
- Middleware registration
- Route configuration
- Policy registration
- Cache and session functionality
- File permissions
- Recent error logs

### Step 2: Clear All Caches (Most Common Fix)
```bash
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### Step 3: Get Complete Error Information
```bash
# Get more detailed logs
tail -n 100 storage/logs/laravel.log

# Search for specific error patterns
grep -A 20 -B 10 "local.ERROR" storage/logs/laravel.log | tail -n 50

# Look for authorization failures
grep -n "403\|Forbidden\|Unauthorized\|Policy\|Gate" storage/logs/laravel.log

# Check today's errors
grep "$(date '+%Y-%m-%d')" storage/logs/laravel.log | tail -n 20
```

## Phase 2: Specific Diagnostics

### Database Issues
If the investigation script shows database problems:

```sql
-- Run these queries to check data integrity
SELECT COUNT(*) as total_users FROM users;
SELECT COUNT(*) as bdsp_users FROM users WHERE role = 'bdsp';
SELECT COUNT(*) as approved_bdsp FROM users WHERE role = 'bdsp' AND approved = 1;

-- Check for role inconsistencies
SELECT id, email, role, approved FROM users WHERE role IS NULL OR role = '';

-- Sample BDSP user data
SELECT id, email, role, approved, created_at FROM users WHERE role = 'bdsp' LIMIT 5;
```

### User Authentication Issues
If users can't access BDSP features:

1. **Check user approval status:**
   ```sql
   SELECT id, email, role, approved FROM users WHERE email = 'user@example.com';
   ```

2. **Verify role assignment:**
   ```sql
   UPDATE users SET approved = 1 WHERE role = 'bdsp' AND approved = 0;
   ```

3. **Test with a known BDSP user:**
   - Log in as a BDSP user
   - Try accessing `/bdsp/training-modules`
   - Check browser developer tools for specific error codes

### Middleware Issues
If middleware is not working:

1. **Check `app/Http/Kernel.php`:**
   ```php
   protected $middlewareAliases = [
       // ... other middleware
       'role' => \App\Http\Middleware\RoleMiddleware::class,
   ];
   ```

2. **Verify RoleMiddleware exists:**
   ```bash
   ls -la app/Http/Middleware/RoleMiddleware.php
   ```

3. **Test middleware directly:**
   ```php
   // Add to a test route
   Route::get('/test-role', function() {
       return 'Role middleware working';
   })->middleware(['auth', 'role:bdsp']);
   ```

### Policy Issues
If authorization policies are failing:

1. **Check `app/Providers/AuthServiceProvider.php`:**
   ```php
   protected $policies = [
       TrainingModule::class => TrainingModulePolicy::class,
   ];
   ```

2. **Test policy directly:**
   ```php
   // In tinker or test script
   $user = User::where('role', 'bdsp')->first();
   $policy = new \App\Policies\TrainingModulePolicy();
   dd($policy->viewAny($user));
   ```

## Phase 3: Environment-Specific Checks

### Production Server Configuration

1. **Check web server configuration:**
   ```bash
   # For Apache
   cat .htaccess
   
   # For Nginx
   nginx -t
   ```

2. **Verify file permissions:**
   ```bash
   # Laravel directories should be writable
   chmod -R 775 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

3. **Check PHP configuration:**
   ```bash
   php -m | grep -E "pdo|mysql|mbstring|openssl"
   ```

### Environment Variables
Verify `.env` file on production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your-database
DB_USERNAME=your-username
DB_PASSWORD=your-password

SESSION_DRIVER=database
CACHE_DRIVER=file
```

## Phase 4: Testing and Validation

### Test Scenarios

1. **Test BDSP user login:**
   - Register as BDSP user
   - Wait for admin approval (or approve manually)
   - Login and access BDSP dashboard

2. **Test training module access:**
   - Navigate to `/bdsp/training-modules`
   - Try creating a new module
   - Check if existing modules are visible

3. **Test different user roles:**
   - Login as entrepreneur, mentor, investor
   - Verify they cannot access BDSP features
   - Confirm proper role-based redirects

### Debugging Commands

```bash
# Enable detailed logging temporarily
echo "LOG_LEVEL=debug" >> .env
echo "APP_DEBUG=true" >> .env

# Monitor logs in real-time
tail -f storage/logs/laravel.log

# Test specific routes
curl -I https://your-domain.com/bdsp/training-modules

# Check database connectivity
php artisan tinker
>>> DB::connection()->getPdo();
>>> User::count();
```

## Common Solutions

### Solution 1: Cache Issues (Most Common)
```bash
php artisan optimize:clear
sudo systemctl restart apache2  # or nginx
```

### Solution 2: Session Issues
```bash
php artisan session:table
php artisan migrate
php artisan config:clear
```

### Solution 3: Permission Issues
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Solution 4: Database Issues
```sql
-- Fix user approval status
UPDATE users SET approved = 1 WHERE role = 'bdsp';

-- Fix role case sensitivity
UPDATE users SET role = LOWER(role);
```

### Solution 5: Middleware Registration
Add to `app/Http/Kernel.php`:
```php
protected $middlewareAliases = [
    'role' => \App\Http\Middleware\RoleMiddleware::class,
];
```

## When to Start Over

Consider rebuilding if:
- Multiple core components are misconfigured
- Database structure is corrupted
- File permissions are extensively wrong
- Environment configuration is severely broken

### Quick Rebuild Checklist
1. Backup current database
2. Fresh Laravel installation
3. Restore database with proper migrations
4. Reconfigure environment variables
5. Set proper file permissions
6. Test with sample users

## Getting Help

If the issue persists:
1. Run the comprehensive investigation script
2. Collect the complete error message from logs
3. Document the exact steps that trigger the 403 error
4. Note any recent changes to the server or codebase
5. Provide the investigation script output for analysis

---

**Remember:** 90% of 403 errors in Laravel are caused by cache issues. Always try clearing caches first!