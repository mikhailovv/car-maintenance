<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250122120851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE services ADD car_id UUID NOT NULL');
        $this->addSql('ALTER TABLE services ALTER mileage DROP DEFAULT');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_SERVICE_TO_CARS FOREIGN KEY (car_id) REFERENCES cars (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_SERVICES_CAR_ID ON services (car_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE services DROP CONSTRAINT FK_SERVICE_TO_CARS');
        $this->addSql('DROP INDEX IDX_SERVICES_CAR_ID');
        $this->addSql('ALTER TABLE services DROP car_id');
        $this->addSql('ALTER TABLE services ALTER mileage SET DEFAULT 0');
    }
}
