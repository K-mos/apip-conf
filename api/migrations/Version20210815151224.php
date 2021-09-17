<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210815151224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE permission_rule_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE permission_rule (id INT NOT NULL, permission_id INT NOT NULL, organization_id INT DEFAULT NULL, service_id INT DEFAULT NULL, position_id INT DEFAULT NULL, manager BOOLEAN DEFAULT \'false\' NOT NULL, level INT DEFAULT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1716376CFED90CCA ON permission_rule (permission_id)');
        $this->addSql('CREATE INDEX IDX_1716376C32C8A3DE ON permission_rule (organization_id)');
        $this->addSql('CREATE INDEX IDX_1716376CED5CA9E6 ON permission_rule (service_id)');
        $this->addSql('CREATE INDEX IDX_1716376CDD842E46 ON permission_rule (position_id)');
        $this->addSql('ALTER TABLE permission_rule ADD CONSTRAINT FK_1716376CFED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE permission_rule ADD CONSTRAINT FK_1716376C32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE permission_rule ADD CONSTRAINT FK_1716376CED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE permission_rule ADD CONSTRAINT FK_1716376CDD842E46 FOREIGN KEY (position_id) REFERENCES position (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE permission_rule_id_seq CASCADE');
        $this->addSql('DROP TABLE permission_rule');
    }
}
