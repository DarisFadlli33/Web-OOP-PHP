
ALTER TABLE `karyawan`
ADD COLUMN `aktif` TINYINT(1) NOT NULL DEFAULT 1 AFTER `status`,
ADD COLUMN `path_image` VARCHAR(255) DEFAULT NULL AFTER `aktif`;

-- Create index on aktif column for faster queries
ALTER TABLE `karyawan` ADD INDEX `idx_aktif` (`aktif`);

-- Update kantor.sql dump to include new columns
-- SELECT * FROM karyawan; -- To verify after migration
