-- Check if columns exist
SELECT 
    COLUMN_NAME
FROM 
    INFORMATION_SCHEMA.COLUMNS 
WHERE 
    TABLE_SCHEMA = DATABASE() 
    AND TABLE_NAME = 'task_user';

-- Check indexes on the table
SHOW INDEX FROM task_user;
