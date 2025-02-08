<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250208115914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars ALTER produced_at SET NOT NULL');
        $this->addSql('ALTER TABLE users ALTER name DROP DEFAULT');
        $this->addSql('ALTER TABLE users ALTER status DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cars ALTER produced_at DROP NOT NULL');
        $this->addSql('ALTER TABLE users ALTER name SET DEFAULT \'default_name\'');
        $this->addSql('ALTER TABLE users ALTER status SET DEFAULT \'ACTIVE\'');
    }
}
