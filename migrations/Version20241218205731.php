<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241218205731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TYPE purchase_type_enum AS ENUM ('service', 'part', 'oil')");
        $this->addSql('CREATE TABLE purchases (id UUID NOT NULL, user_id UUID DEFAULT NULL, quantity DOUBLE PRECISION NOT NULL, purchase_type purchase_type_enum NOT NULL, unit_price_amount NUMERIC(33, 18) NOT NULL, unit_price_currency_code VARCHAR(3) NOT NULL, total_price_amount NUMERIC(33, 18) NOT NULL, total_price_currency_code VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_PURCHASES_USER_ID ON purchases (user_id)');
        $this->addSql('ALTER TABLE purchases ADD CONSTRAINT FK_USER_ID FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE purchases DROP CONSTRAINT FK_USER_ID');
        $this->addSql('DROP TABLE purchases');
        $this->addSql('DROP TYPE purchase_type_enum');
    }
}
