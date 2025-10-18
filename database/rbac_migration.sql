-- RBAC Migration for iReport System
-- This script unifies admin and users tables and adds role-based access control

-- Step 1: Check current users table structure
DESCRIBE users;

-- Step 2: Add role column to existing users table if it doesn't exist
ALTER TABLE `users` 
ADD COLUMN `role` ENUM('admin','user') NOT NULL DEFAULT 'user' AFTER `status`;

-- Step 3: Add image column if it doesn't exist (for profile pictures)
ALTER TABLE `users` 
ADD COLUMN `image` VARCHAR(255) NULL AFTER `name`;

-- Step 4: Add is_verified column if it doesn't exist
ALTER TABLE `users` 
ADD COLUMN `is_verified` TINYINT(1) NOT NULL DEFAULT 1 AFTER `image`;

-- Step 5: Add verification_token column if it doesn't exist
ALTER TABLE `users` 
ADD COLUMN `verification_token` VARCHAR(255) NULL AFTER `is_verified`;

-- Step 6: Add timestamps if they don't exist
ALTER TABLE `users` 
ADD COLUMN `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER `verification_token`,
ADD COLUMN `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`;

-- Step 7: Migrate existing admin data to users table with admin role
INSERT INTO `users` (`email`, `password`, `name`, `status`, `role`, `is_verified`, `created_at`) 
SELECT `email`, `password`, `name`, `status`, 'admin' as `role`, 1 as `is_verified`, NOW() 
FROM `admin` 
WHERE `email` NOT IN (SELECT `email` FROM `users`);

-- Step 8: Update existing users to have verified status (for backward compatibility)
UPDATE `users` SET `is_verified` = 1 WHERE `is_verified` = 0;

-- Step 9: Add indexes for better performance
ALTER TABLE `users` ADD INDEX `idx_email` (`email`);
ALTER TABLE `users` ADD INDEX `idx_role` (`role`);
ALTER TABLE `users` ADD INDEX `idx_status` (`status`);

-- Step 10: Create role changes audit table
CREATE TABLE IF NOT EXISTS `role_changes_log` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `admin_id` INT NOT NULL,
  `target_user_id` INT NOT NULL,
  `old_role` VARCHAR(50),
  `new_role` VARCHAR(50),
  `changed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_admin_id` (`admin_id`),
  INDEX `idx_target_user_id` (`target_user_id`),
  INDEX `idx_changed_at` (`changed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Verification queries
SELECT 'Migration completed successfully!' as status;
SELECT role, COUNT(*) as count FROM users GROUP BY role;
SELECT 'Total users:', COUNT(*) FROM users;
