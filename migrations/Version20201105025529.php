<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201105025529 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX nom ON hopital');
        $this->addSql('ALTER TABLE medecin CHANGE biographie biographie LONGTEXT NOT NULL');
        $this->addSql('DROP INDEX nom ON service');
        $this->addSql('ALTER TABLE suivi ADD etat VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX nom ON hopital (nom)');
        $this->addSql('ALTER TABLE medecin CHANGE biographie biographie VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE UNIQUE INDEX nom ON service (nom)');
        $this->addSql('ALTER TABLE suivi DROP etat');
    }
}
