<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241216150600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parts (id UUID NOT NULL, category_id INT NOT NULL, user_id UUID DEFAULT NULL, brand VARCHAR(255) NOT NULL, part_number VARCHAR(255) NOT NULL, original_part_number VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_PARTS_CATEGORY_ID ON parts (category_id)');
        $this->addSql('ALTER TABLE parts ADD CONSTRAINT FK_CATEGORIES_ID FOREIGN KEY (category_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parts ADD CONSTRAINT FK_USERS FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parts DROP CONSTRAINT FK_CATEGORIES_ID');
        $this->addSql('ALTER TABLE parts DROP CONSTRAINT FK_USERS');
        $this->addSql('DROP TABLE parts');
    }
}
