<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250208120444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brands (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cars (id UUID NOT NULL, user_id UUID NOT NULL, name VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, produced_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, color VARCHAR(255) NOT NULL, registration_number VARCHAR(255) NOT NULL, vin VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_95C71D14A76ED395 ON cars (user_id)');
        $this->addSql('COMMENT ON COLUMN cars.produced_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN cars.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN cars.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE categories (id SERIAL NOT NULL, parent_category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3AF34668796A8F92 ON categories (parent_category_id)');
        $this->addSql('COMMENT ON COLUMN categories.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN categories.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE models (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, brand_slug VARCHAR(255) NOT NULL, weight INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_brand_slug ON models (brand_slug)');
        $this->addSql('CREATE TABLE parts (id UUID NOT NULL, user_id UUID DEFAULT NULL, category_id INT NOT NULL, car_id UUID DEFAULT NULL, service_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, part_number VARCHAR(255) NOT NULL, original_part_number VARCHAR(255) NOT NULL, quantity DOUBLE PRECISION NOT NULL, status VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, unit_price_amount NUMERIC(33, 18) NOT NULL, unit_price_currency_code VARCHAR(3) NOT NULL, total_price_amount NUMERIC(33, 18) NOT NULL, total_price_currency_code VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6940A7FEC3C6F69F ON parts (car_id)');
        $this->addSql('CREATE INDEX IDX_6940A7FE12469DE2 ON parts (category_id)');
        $this->addSql('CREATE INDEX IDX_6940A7FEED5CA9E6 ON parts (service_id)');
        $this->addSql('CREATE INDEX IDX_6940A7FEA76ED395 ON parts (user_id)');
        $this->addSql('COMMENT ON COLUMN parts.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE services (id UUID NOT NULL, user_id UUID NOT NULL, car_id UUID NOT NULL, name VARCHAR(255) NOT NULL, quantity DOUBLE PRECISION NOT NULL, shop VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, mileage INT NOT NULL, unit_price_amount NUMERIC(33, 18) NOT NULL, unit_price_currency_code VARCHAR(3) NOT NULL, total_price_amount NUMERIC(33, 18) NOT NULL, total_price_currency_code VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7332E169A76ED395 ON services (user_id)');
        $this->addSql('CREATE INDEX IDX_7332E169C3C6F69F ON services (car_id)');
        $this->addSql('COMMENT ON COLUMN services.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN services.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE users (id UUID NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, registered_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN users.registered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN users.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D14A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668796A8F92 FOREIGN KEY (parent_category_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts ADD CONSTRAINT FK_6940A7FEC3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts ADD CONSTRAINT FK_6940A7FE12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts ADD CONSTRAINT FK_6940A7FEED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts ADD CONSTRAINT FK_6940A7FEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169C3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars DROP CONSTRAINT FK_95C71D14A76ED395');
        $this->addSql('ALTER TABLE categories DROP CONSTRAINT FK_3AF34668796A8F92');
        $this->addSql('ALTER TABLE parts DROP CONSTRAINT FK_6940A7FEC3C6F69F');
        $this->addSql('ALTER TABLE parts DROP CONSTRAINT FK_6940A7FE12469DE2');
        $this->addSql('ALTER TABLE parts DROP CONSTRAINT FK_6940A7FEED5CA9E6');
        $this->addSql('ALTER TABLE parts DROP CONSTRAINT FK_6940A7FEA76ED395');
        $this->addSql('ALTER TABLE services DROP CONSTRAINT FK_7332E169A76ED395');
        $this->addSql('ALTER TABLE services DROP CONSTRAINT FK_7332E169C3C6F69F');
        $this->addSql('DROP TABLE brands');
        $this->addSql('DROP TABLE cars');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE models');
        $this->addSql('DROP TABLE parts');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE users');
    }
}
