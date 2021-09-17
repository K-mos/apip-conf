<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210829130208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permission_rule ADD filters TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE permission_rule DROP level');
        $this->addSql('ALTER TABLE permission_rule DROP type');
        $this->addSql('COMMENT ON COLUMN permission_rule.filters IS \'(DC2Type:simple_array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE permission_rule ADD level INT DEFAULT NULL');
        $this->addSql('ALTER TABLE permission_rule ADD type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE permission_rule DROP filters');
    }
}
