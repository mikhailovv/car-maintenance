<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219190402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE inventories (id UUID NOT NULL, part_id UUID DEFAULT NULL, user_id UUID DEFAULT NULL, quantity DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX IDX_INVENTORIES_PART_ID ON inventories (part_id)');
        $this->addSql('CREATE INDEX IDX_INVENTORIES_USER_ID ON inventories (user_id)');
        $this->addSql('ALTER TABLE inventories ADD CONSTRAINT FK_PART_ID FOREIGN KEY (part_id) REFERENCES parts (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE inventories ADD CONSTRAINT FK_USER_ID FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE inventories DROP CONSTRAINT FK_USER_ID');
        $this->addSql('ALTER TABLE inventories DROP CONSTRAINT FK_PART_ID');
        $this->addSql('DROP TABLE inventories');
    }
}
