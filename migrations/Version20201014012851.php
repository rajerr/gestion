<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201014012851 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE analyse ADD date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE ordonnance ADD date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE resultat ADD date DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE analyse DROP date');
        $this->addSql('ALTER TABLE ordonnance DROP date');
        $this->addSql('ALTER TABLE resultat DROP date');
    }
}
