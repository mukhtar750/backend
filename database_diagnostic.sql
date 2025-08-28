-- BDSP Training Module Database Diagnostic Queries
-- Run these queries on your production database to check data integrity

-- 1. Check all users and their roles
SELECT 
    id, 
    name, 
    email, 
    role, 
    is_approved, 
    created_at,
    CHAR_LENGTH(role) as role_length,
    ASCII(SUBSTRING(role, 1, 1)) as first_char_ascii
FROM users 
ORDER BY role, created_at DESC;

-- 2. Specifically check BDSP users
SELECT 
    id, 
    name, 
    email, 
    role, 
    is_approved,
    services_provided,
    years_of_experience,
    organization
FROM users 
WHERE role LIKE '%bdsp%' OR role LIKE '%BDSP%'
ORDER BY created_at DESC;

-- 3. Check training modules and their ownership
SELECT 
    tm.id,
    tm.title,
    tm.status,
    tm.bdsp_id,
    u.name as bdsp_name,
    u.email as bdsp_email,
    u.role as bdsp_role,
    u.is_approved as bdsp_approved,
    tm.created_at
FROM training_modules tm
LEFT JOIN users u ON tm.bdsp_id = u.id
ORDER BY tm.created_at DESC;

-- 4. Check for role inconsistencies
SELECT 
    role,
    COUNT(*) as count,
    GROUP_CONCAT(DISTINCT role) as unique_roles
FROM users 
GROUP BY role
ORDER BY count DESC;

-- 5. Check pairings table (if exists)
SELECT 
    p.id,
    p.user_one_id,
    u1.name as user_one_name,
    u1.role as user_one_role,
    p.user_two_id,
    u2.name as user_two_name,
    u2.role as user_two_role,
    p.type,
    p.status,
    p.created_at
FROM pairings p
LEFT JOIN users u1 ON p.user_one_id = u1.id
LEFT JOIN users u2 ON p.user_two_id = u2.id
WHERE u1.role = 'bdsp' OR u2.role = 'bdsp'
ORDER BY p.created_at DESC;

-- 6. Check module completions
SELECT 
    mc.id,
    mc.module_id,
    tm.title as module_title,
    mc.entrepreneur_id,
    ue.name as entrepreneur_name,
    mc.bdsp_id,
    ub.name as bdsp_name,
    mc.status,
    mc.progress_percentage,
    mc.created_at
FROM module_completions mc
LEFT JOIN training_modules tm ON mc.module_id = tm.id
LEFT JOIN users ue ON mc.entrepreneur_id = ue.id
LEFT JOIN users ub ON mc.bdsp_id = ub.id
ORDER BY mc.created_at DESC
LIMIT 20;

-- 7. Check for any NULL or empty roles
SELECT 
    id,
    name,
    email,
    role,
    is_approved
FROM users 
WHERE role IS NULL 
   OR role = '' 
   OR TRIM(role) = ''
ORDER BY created_at DESC;

-- 8. Check database collation and charset
SELECT 
    TABLE_SCHEMA,
    TABLE_NAME,
    COLUMN_NAME,
    CHARACTER_SET_NAME,
    COLLATION_NAME
FROM information_schema.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE()
  AND TABLE_NAME = 'users'
  AND COLUMN_NAME = 'role';

-- 9. Check for duplicate emails or unusual data
SELECT 
    email,
    COUNT(*) as count,
    GROUP_CONCAT(id) as user_ids,
    GROUP_CONCAT(role) as roles
FROM users 
GROUP BY email 
HAVING COUNT(*) > 1;

-- 10. Check recent activity in training modules
SELECT 
    'training_modules' as table_name,
    COUNT(*) as total_records,
    MAX(created_at) as latest_created,
    MAX(updated_at) as latest_updated
FROM training_modules
UNION ALL
SELECT 
    'users' as table_name,
    COUNT(*) as total_records,
    MAX(created_at) as latest_created,
    MAX(updated_at) as latest_updated
FROM users
UNION ALL
SELECT 
    'pairings' as table_name,
    COUNT(*) as total_records,
    MAX(created_at) as latest_created,
    MAX(updated_at) as latest_updated
FROM pairings;

-- Instructions for use:
-- 1. Connect to your production database
-- 2. Run these queries one by one
-- 3. Look for:
--    - Users with role != 'bdsp' but should be BDSP
--    - Users with is_approved = 0 who should be approved
--    - Training modules without valid bdsp_id
--    - Missing or broken relationships
--    - Character encoding issues in role field
-- 4. Document any anomalies found