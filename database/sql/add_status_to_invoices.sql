ALTER TABLE `invoices`
ADD COLUMN `status` VARCHAR(255) NULL AFTER `customer_address`;

UPDATE `invoices`
SET `status` = 'Selesai'
WHERE `status` IS NULL;

ALTER TABLE `invoices`
MODIFY COLUMN `status` VARCHAR(255) NOT NULL DEFAULT 'Pending';
