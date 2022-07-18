<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220718183918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Makes `name` and `address` nullable in `customer`';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
                ALTER TABLE `customer_db`.`customer` MODIFY `name` VARCHAR(50) DEFAULT NULL;
                ALTER TABLE `customer_db`.`customer` MODIFY `address` VARCHAR(100) DEFAULT NULL;
            SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
                ALTER TABLE `customer_db`.`customer` MODIFY `name` VARCHAR(50) NOT NULL;
                ALTER TABLE `customer_db`.`customer` MODIFY `address` VARCHAR(100) NOT NULL;
            SQL
        );
    }
}
