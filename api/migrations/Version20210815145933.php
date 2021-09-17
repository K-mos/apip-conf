<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210815145933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE greeting_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE organization_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE permission_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE position_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE service_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE organization (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE permission (id INT NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE position (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE service (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE greeting');
        $this->addSql('ALTER TABLE "user" ADD organization_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD position_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD level INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD manager BOOLEAN DEFAULT \'false\' NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D64932C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649DD842E46 FOREIGN KEY (position_id) REFERENCES position (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D64932C8A3DE ON "user" (organization_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649ED5CA9E6 ON "user" (service_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649DD842E46 ON "user" (position_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D64932C8A3DE');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649DD842E46');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649ED5CA9E6');
        $this->addSql('DROP SEQUENCE organization_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE permission_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE position_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE service_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE greeting_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE greeting (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE position');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP INDEX IDX_8D93D64932C8A3DE');
        $this->addSql('DROP INDEX IDX_8D93D649ED5CA9E6');
        $this->addSql('DROP INDEX IDX_8D93D649DD842E46');
        $this->addSql('ALTER TABLE "user" DROP organization_id');
        $this->addSql('ALTER TABLE "user" DROP service_id');
        $this->addSql('ALTER TABLE "user" DROP position_id');
        $this->addSql('ALTER TABLE "user" DROP level');
        $this->addSql('ALTER TABLE "user" DROP manager');
    }
}
