# Testing Alternative Resource Sharing System

This guide explains how to test the new alternative resource sharing system that bypasses the 403 authorization issues.

## 🎯 What We're Testing

The alternative sharing system uses:
- **New Route**: `/bdsp/resources/{resource}/share-alt`
- **New Method**: `shareAlternative()` in `ResourceController`
- **Direct Authorization**: Simple ownership checks instead of Laravel policies

## 🧪 Testing Steps

### 1. **Local Testing (Development)**

#### A. Run the Test Script
```bash
php test_alternative_sharing.php
```

**Expected Output:**
```
✅ Found BDSP user: [Name] (ID: [ID])
✅ Found resource: [Title] (ID: [ID])
✅ Found entrepreneur: [Name] (ID: [ID])
✅ Authenticated as BDSP user
✅ User role check passed: bdsp
✅ Resource ownership check passed
✅ All authorization checks passed for alternative method
```

#### B. Test via Artisan Command
```bash
php artisan test:resource-sharing
```

### 2. **Production Testing (Manual)**

#### A. Login as BDSP User
1. Go to your production site
2. Login with a BDSP account that has uploaded resources
3. Navigate to resource management

#### B. Test Resource Sharing
1. Click on "Share" for any approved resource
2. Select one or more entrepreneurs
3. Add an optional message
4. Click "Share Resource"

**Expected Results:**
- ✅ No 403 error
- ✅ Success message: "Resource shared with X entrepreneur(s) successfully!"
- ✅ Entrepreneurs receive notifications
- ✅ Resource appears in entrepreneur's shared resources

#### C. Verify Database Changes
Check the `resource_shares` table:
```sql
SELECT * FROM resource_shares 
WHERE resource_id = [RESOURCE_ID] 
AND shared_by = [BDSP_ID] 
ORDER BY created_at DESC;
```

### 3. **Browser Testing Checklist**

#### ✅ **Before Testing**
- [ ] Clear browser cache
- [ ] Ensure you're logged in as a BDSP user
- [ ] Verify the resource is approved by admin
- [ ] Check that entrepreneurs are paired with the BDSP

#### ✅ **During Testing**
- [ ] Resource sharing page loads without errors
- [ ] Entrepreneur list displays correctly
- [ ] Form submission works (no 403 error)
- [ ] Success/error messages display properly
- [ ] Already shared resources show "Already Shared" status

#### ✅ **After Testing**
- [ ] Check entrepreneur's dashboard for shared resource
- [ ] Verify notification was sent
- [ ] Test unsharing functionality
- [ ] Confirm database records are created

### 4. **Network Debugging**

#### Check Browser Developer Tools
1. Open Developer Tools (F12)
2. Go to Network tab
3. Submit the sharing form
4. Look for the POST request to `/bdsp/resources/{id}/share-alt`

**Expected Response:**
- Status: `302` (redirect)
- No `403 Forbidden` errors
- Redirect to resource sharing page with success message

### 5. **Error Scenarios to Test**

#### A. Unauthorized Access
- Try accessing another BDSP's resource sharing page
- **Expected**: 403 error with "Unauthorized to share this resource"

#### B. Invalid Data
- Submit form with no entrepreneurs selected
- **Expected**: Validation error

#### C. Non-BDSP User
- Login as entrepreneur/mentor and try to access sharing
- **Expected**: 403 error or redirect

### 6. **Performance Testing**

#### A. Multiple Entrepreneurs
- Test sharing with 10+ entrepreneurs at once
- **Expected**: All shares created, all notifications sent

#### B. Large Resources
- Test sharing large files (videos, documents)
- **Expected**: Sharing works regardless of file size

## 🔍 Troubleshooting

### If Alternative Sharing Still Fails:

1. **Check Route Registration**
   ```bash
   php artisan route:list | grep share-alt
   ```

2. **Clear All Caches**
   ```bash
   php artisan route:clear
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

3. **Check Server Logs**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Verify Database Connection**
   ```bash
   php artisan tinker
   >>> DB::connection()->getPdo();
   ```

### Common Issues:

| Issue | Solution |
|-------|----------|
| Route not found | Run `php artisan route:clear` |
| Method not found | Check controller file exists and method is public |
| Database errors | Verify database connection and table structure |
| Permission denied | Check file permissions on server |

## 📊 Success Metrics

### ✅ **Test Passes If:**
- No 403 errors during sharing process
- Resources are successfully shared with entrepreneurs
- Database records are created correctly
- Notifications are sent to entrepreneurs
- Shared resources appear in entrepreneur dashboards

### ❌ **Test Fails If:**
- 403 Forbidden errors still occur
- Sharing form doesn't submit
- Database records aren't created
- Notifications aren't sent
- Server errors in logs

## 🚀 Deployment Verification

After deploying to production:

1. **Immediate Checks**
   - [ ] Site loads without errors
   - [ ] BDSP users can access resource sharing
   - [ ] Alternative route is accessible

2. **Functional Tests**
   - [ ] Complete one full sharing workflow
   - [ ] Verify entrepreneur receives notification
   - [ ] Check database for new records

3. **Rollback Plan**
   - If issues persist, revert to previous commit
   - Re-enable original sharing route temporarily
   - Investigate root cause of authorization problems

## 📝 Notes

- The original sharing route (`/share`) is still available as backup
- Alternative route uses same validation and business logic
- Only the authorization method is different
- All security checks are maintained through direct ownership validation

---

**Need Help?** Check the troubleshooting section or review the implementation in:
- `app/Http/Controllers/ResourceController.php` (shareAlternative method)
- `routes/web.php` (alternative route)
- `resources/views/bdsp/resource-sharing.blade.php` (updated form)