<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210829131810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD manager_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" DROP level');
        $this->addSql('ALTER TABLE "user" DROP manager');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649783E3463 FOREIGN KEY (manager_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D649783E3463 ON "user" (manager_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649783E3463');
        $this->addSql('DROP INDEX IDX_8D93D649783E3463');
        $this->addSql('ALTER TABLE "user" ADD level INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD manager BOOLEAN DEFAULT \'false\' NOT NULL');
        $this->addSql('ALTER TABLE "user" DROP manager_id');
    }
}
