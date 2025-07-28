# 🚀 Laravel cPanel Automatic Deployment Guide

## 📋 Prerequisites

### 1. **cPanel Access**
- Namecheap hosting with cPanel access
- Git repository (GitHub/GitLab/Bitbucket)
- SSH access (recommended)

### 2. **Repository Setup**
- Your Laravel project must be in a Git repository
- Repository must be public or you need to set up SSH keys

## 🔧 Setup Steps

### **Step 1: Configure .cpanel.yml**
1. **Update the deployment path** in `.cpanel.yml`:
   ```yaml
   - export DEPLOYPATH=/home/YOUR_CPANEL_USERNAME/public_html/
   - export COMPOSER_HOME=/home/YOUR_CPANEL_USERNAME/.composer
   ```

2. **Replace `YOUR_CPANEL_USERNAME`** with your actual cPanel username

### **Step 2: Environment Configuration**
1. **Create `.env` file** on your server with production settings:
   ```env
   APP_NAME="VR Portal"
   APP_ENV=production
   APP_KEY=base64:your-key-here
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   
   CACHE_DRIVER=file
   SESSION_DRIVER=file
   QUEUE_CONNECTION=sync
   ```

### **Step 3: cPanel Git Version Control**
1. **Login to cPanel**
2. **Find "Git Version Control"** in the Files section
3. **Click "Create"**
4. **Repository Details:**
   - **Repository Name:** `laravel-app`
   - **Repository URL:** `https://github.com/yourusername/your-repo.git`
   - **Branch:** `main` (or your default branch)
   - **Deploy Path:** `/public_html/`
5. **Click "Create"**

### **Step 4: Automatic Deployment**
1. **In Git Version Control, click "Manage"**
2. **Enable "Deploy on Push"**
3. **The `.cpanel.yml` file will automatically run on each push**

## 🔄 Deployment Process

### **What Happens on Each Push:**
1. ✅ **Composer install** (production dependencies only)
2. ✅ **Create necessary directories**
3. ✅ **Set proper permissions**
4. ✅ **Generate application key**
5. ✅ **Clear all caches**
6. ✅ **Run migrations** (with --force)
7. ✅ **Cache config, routes, views**
8. ✅ **Optimize for production**
9. ✅ **Set final permissions**

## 🛠️ Manual Deployment (if needed)

### **Via cPanel Terminal:**
```bash
cd public_html
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## 🔍 Troubleshooting

### **Common Issues:**

1. **Permission Errors:**
   ```bash
   chmod -R 755 storage/
   chmod -R 755 bootstrap/cache/
   ```

2. **Composer Not Found:**
   - Use full path: `/opt/cpanel/composer/bin/composer`

3. **Database Connection:**
   - Check `.env` file exists and has correct database credentials

4. **500 Error:**
   - Check `storage/logs/laravel.log` for errors
   - Ensure `.htaccess` file exists

### **Log Locations:**
- **Laravel Logs:** `storage/logs/laravel.log`
- **cPanel Deployment Logs:** In Git Version Control → Manage → Logs

## 📞 Namecheap Support

### **If you need help:**
1. **Contact Namecheap Support** via live chat
2. **Reference:** "Laravel Git deployment with .cpanel.yml"
3. **Share this documentation** with them

### **Required Information for Support:**
- Your cPanel username
- Domain name
- Git repository URL
- Any error messages from logs

## 🎯 Best Practices

1. **Always test locally** before pushing
2. **Keep `.env` file secure** (never commit to Git)
3. **Monitor deployment logs** after each push
4. **Backup database** before major deployments
5. **Use staging environment** for testing

## 🚀 Next Steps

1. **Update `.cpanel.yml`** with your cPanel username
2. **Set up Git Version Control** in cPanel
3. **Configure `.env`** file on server
4. **Test deployment** with a small change
5. **Monitor logs** for any issues

---

**Need help?** Contact Namecheap support with this guide and your specific error messages. 