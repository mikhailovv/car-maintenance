<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241125115226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE models (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, brand_slug VARCHAR(255) NOT NULL, weight INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_brand_slug ON models (brand_slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE models');
    }
}
