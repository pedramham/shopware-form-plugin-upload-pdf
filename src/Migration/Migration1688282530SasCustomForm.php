<?php declare(strict_types=1);

namespace Sas\CustomForm\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1688282530SasCustomForm extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1688282530;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('
            CREATE TABLE IF NOT EXISTS `sas_custom_form_table` (
                `id` BINARY(16) NOT NULL,
                 `media_id` BINARY(16) NULL,
                `first_name` VARCHAR(50) COLLATE utf8mb4_unicode_ci  NOT NULL,
                `last_name` VARCHAR(50) COLLATE utf8mb4_unicode_ci  NOT NULL,
                `email` VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL,
                `phone_number` VARCHAR(50) COLLATE utf8mb4_unicode_ci  NULL,
                `company` VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL,
                `street` VARCHAR(254) COLLATE utf8mb4_unicode_ci  NULL,
                `street_number` VARCHAR(100) COLLATE utf8mb4_unicode_ci  NULL,
                `postal_code` VARCHAR(100) COLLATE utf8mb4_unicode_ci  NULL,
                `country` VARCHAR(80) COLLATE utf8mb4_unicode_ci  NULL,
                `city` VARCHAR(50) COLLATE utf8mb4_unicode_ci  NULL,
                `description` VARCHAR(300) COLLATE utf8mb4_unicode_ci  NULL,
                `created_at` DATETIME(3) NOT NULL,
                `updated_at` DATETIME(3) NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
