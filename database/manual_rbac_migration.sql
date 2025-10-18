-- Manual RBAC Migration for iReport
-- Copy and paste this into phpMyAdmin SQL tab and run

-- Check current table structure
DESCRIBE users;

-- Add role column
ALTER TABLE `users` ADD COLUMN `role` VARCHAR(50) NOT NULL DEFAULT 'user' AFTER `status`;

-- Add verification columns  
ALTER TABLE `users` ADD COLUMN `is_verified` TINYINT(1) NOT NULL DEFAULT 1 AFTER `role`;
ALTER TABLE `users` ADD COLUMN `verification_token` VARCHAR(255) NULL AFTER `is_verified`;
ALTER TABLE `users` ADD COLUMN `token_expiry` DATETIME NULL AFTER `verification_token`;

-- Add timestamp columns
ALTER TABLE `users` ADD COLUMN `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER `token_expiry`;
ALTER TABLE `users` ADD COLUMN `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`;

-- Set existing users to 'user' role and verified status
UPDATE `users` SET `role` = 'user', `is_verified` = 1 WHERE `role` IS NULL OR `role` = '';

-- Migrate admin data to users table with admin role (if admin table exists)
INSERT INTO `users` (`email`, `password`, `name`, `status`, `role`, `is_verified`, `created_at`) 
SELECT `email`, `password`, `name`, `status`, 'admin' as `role`, 1 as `is_verified`, NOW() 
FROM `admin` 
WHERE EXISTS (SELECT 1 FROM information_schema.tables WHERE table_schema = 'ireport' AND table_name = 'admin')
AND `email` NOT IN (SELECT `email` FROM `users`);

-- Add indexes for better performance
ALTER TABLE `users` ADD INDEX `idx_email` (`email`);
ALTER TABLE `users` ADD INDEX `idx_role` (`role`);
ALTER TABLE `users` ADD INDEX `idx_status` (`status`);

-- Create role changes audit table
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

-- Create user permissions table (for future expansion)
CREATE TABLE IF NOT EXISTS `user_permissions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `resource` VARCHAR(100) NOT NULL,
  `action` VARCHAR(100) NOT NULL,
  `granted` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `unique_permission` (`user_id`, `resource`, `action`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_resource` (`resource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Verification queries
SELECT 'RBAC Migration completed successfully!' as status;
SELECT role, COUNT(*) as count FROM users GROUP BY role;
SELECT 'Total users:', COUNT(*) FROM users;

-- Check final table structure
DESCRIBE users;
