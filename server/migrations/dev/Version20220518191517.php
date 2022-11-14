<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220518191517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables and its relationships';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
                CREATE TABLE `customer_db`.`customer` (
                    `id` CHAR(36) PRIMARY KEY NOT NULL,
                    `name` VARCHAR(50) DEFAULT NULL,
                    `email` VARCHAR(100) DEFAULT NULL,
                    `address` VARCHAR(100) DEFAULT NULL,
                    `age` SMALLINT NOT NULL,
                    `employee_id` CHAR(36) NOT NULL,
                    INDEX IDX_customer_name (`name`),
                    INDEX IDX_employee_id (`employee_id`),
                    UNIQUE U_customer_email (`email`)
                );

                CREATE TABLE `employee_db`.`employee` (
                    `id` CHAR(36) PRIMARY KEY NOT NULL,
                    `name` VARCHAR(50) DEFAULT NULL,
                    `email` VARCHAR(100) DEFAULT NULL,
                    `password` VARCHAR(250) DEFAULT NULL,
                    INDEX IDX_employee_name (`name`),
                    UNIQUE U_employee_email (`email`)
                );

                CREATE TABLE `rental_db`.`car` (
                    `id` CHAR(36) PRIMARY KEY NOT NULL,
                    `brand` VARCHAR(50) DEFAULT NULL,
                    `model` VARCHAR(50) DEFAULT NULL,
                    `color` VARCHAR(50) DEFAULT NULL,
                    INDEX IDX_car_brand (`brand`),
                    INDEX IDX_car_model (`model`),
                    INDEX IDX_car_color (`color`)
                );

                CREATE TABLE `rental_db`.`rental` (
                    `id` CHAR(36) PRIMARY KEY NOT NULL,
                    `customer_id` CHAR(36) NOT NULL,
                    `employee_id` CHAR(36) NOT NULL,
                    `car_id` CHAR(36) NOT NULL,
                    `start_date` DATETIME DEFAULT NULL,
                    `end_date` DATETIME DEFAULT NULL,
                    INDEX IDX_rental_customer_id (`customer_id`),
                    INDEX IDX_rental_employee_id (`employee_id`),
                    INDEX IDX_rental_car_id (`car_id`),
                    CONSTRAINT FK_rental_car_id FOREIGN KEY (`car_id`) REFERENCES `rental_db`.`car`(`id`) ON UPDATE CASCADE ON DELETE CASCADE 
                );
            SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
                DROP TABLE `rental_db`.`rental`;
                DROP TABLE `rental_db`.`car`;
                DROP TABLE `customer_db`.`customer`;
                DROP TABLE `employee_db`.`employee`;
            SQL
        );
    }
}
