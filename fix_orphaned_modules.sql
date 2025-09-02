-- Fix orphaned training modules
-- This script will clean up training modules that have no valid BDSP owner

-- First, let's see what we're dealing with
SELECT 
    tm.id,
    tm.title,
    tm.bdsp_id,
    u.name as owner_name,
    u.role as owner_role
FROM training_modules tm
LEFT JOIN users u ON tm.bdsp_id = u.id
WHERE u.id IS NULL OR u.role != 'bdsp';

-- Option 1: Assign orphaned modules to the first approved BDSP
UPDATE training_modules tm
LEFT JOIN users u ON tm.bdsp_id = u.id
SET tm.bdsp_id = (
    SELECT id FROM users 
    WHERE role = 'bdsp' AND is_approved = 1 
    ORDER BY id ASC 
    LIMIT 1
)
WHERE u.id IS NULL OR u.role != 'bdsp';

-- Option 2: Delete orphaned modules (uncomment if you want to remove them)
-- DELETE tm FROM training_modules tm
-- LEFT JOIN users u ON tm.bdsp_id = u.id
-- WHERE u.id IS NULL OR u.role != 'bdsp';

-- Verify the fix
SELECT 
    tm.id,
    tm.title,
    tm.bdsp_id,
    u.name as owner_name,
    u.role as owner_role
FROM training_modules tm
LEFT JOIN users u ON tm.bdsp_id = u.id;
