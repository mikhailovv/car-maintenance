<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241224215434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parts (id UUID NOT NULL, user_id UUID DEFAULT NULL, category_id INT NOT NULL, car_id UUID DEFAULT NULL, service_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, part_number VARCHAR(255) NOT NULL, original_part_number VARCHAR(255) NOT NULL, quantity DOUBLE PRECISION NOT NULL, status VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, unit_price_amount NUMERIC(33, 18) NOT NULL, unit_price_currency_code VARCHAR(3) NOT NULL, total_price_amount NUMERIC(33, 18) NOT NULL, total_price_currency_code VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_PARTS_TO_CAR ON parts (car_id)');
        $this->addSql('CREATE INDEX IDX_PARTS_TO_CATEGORY ON parts (category_id)');
        $this->addSql('CREATE INDEX IDX_PARTS_TO_SERVICE ON parts (service_id)');
        $this->addSql('CREATE INDEX IDX_PARTS_TO_USER ON parts (user_id)');
        $this->addSql('COMMENT ON COLUMN parts.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE services (id UUID NOT NULL, user_id UUID NOT NULL, name VARCHAR(255) NOT NULL, quantity DOUBLE PRECISION NOT NULL, shop VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, unit_price_amount NUMERIC(33, 18) NOT NULL, unit_price_currency_code VARCHAR(3) NOT NULL, total_price_amount NUMERIC(33, 18) NOT NULL, total_price_currency_code VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_SERVICES_TO_USER ON services (user_id)');
        $this->addSql('COMMENT ON COLUMN services.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN services.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE parts ADD CONSTRAINT FK_PARTS_TO_CAR FOREIGN KEY (car_id) REFERENCES cars (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts ADD CONSTRAINT FK_PARTS_TO_CATEGORY FOREIGN KEY (category_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts ADD CONSTRAINT FK_PARTS_TO_SERVICE FOREIGN KEY (service_id) REFERENCES services (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts ADD CONSTRAINT FK_PARTS_TO_USER FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_SERVICES_TO_USER FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('COMMENT ON COLUMN cars.produced_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE parts DROP CONSTRAINT FK_PARTS_TO_CAR');
        $this->addSql('ALTER TABLE parts DROP CONSTRAINT FK_PARTS_TO_CATEGORY');
        $this->addSql('ALTER TABLE parts DROP CONSTRAINT FK_PARTS_TO_SERVICE');
        $this->addSql('ALTER TABLE parts DROP CONSTRAINT FK_PARTS_TO_USER');
        $this->addSql('ALTER TABLE services DROP CONSTRAINT FK_SERVICES_TO_USER');
        $this->addSql('DROP TABLE parts');
        $this->addSql('DROP TABLE services');
    }
}
