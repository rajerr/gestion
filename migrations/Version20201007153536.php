<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201007153536 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE analyse (id INT AUTO_INCREMENT NOT NULL, prescription_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, details LONGTEXT NOT NULL, INDEX IDX_351B0C7E93DB413D (prescription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultation (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, medecin_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, date DATETIME NOT NULL, poids INT NOT NULL, temperature INT NOT NULL, tension VARCHAR(255) NOT NULL, diagnostique LONGTEXT NOT NULL, INDEX IDX_964685A66B899279 (patient_id), INDEX IDX_964685A64F31A84 (medecin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hopital (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, contact INT NOT NULL, email VARCHAR(255) NOT NULL, boite_postal INT NOT NULL, fax VARCHAR(255) NOT NULL, logo LONGBLOB NOT NULL, statut TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hopital_service (id INT AUTO_INCREMENT NOT NULL, hopital_id INT DEFAULT NULL, service_id INT DEFAULT NULL, medecin_id INT DEFAULT NULL, INDEX IDX_B55C0308CC0FBF92 (hopital_id), INDEX IDX_B55C0308ED5CA9E6 (service_id), INDEX IDX_B55C03084F31A84 (medecin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordonnance (id INT AUTO_INCREMENT NOT NULL, prescription_id INT DEFAULT NULL, mentions VARCHAR(255) NOT NULL, details LONGTEXT NOT NULL, INDEX IDX_924B326C93DB413D (prescription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prescription (id INT AUTO_INCREMENT NOT NULL, consultation_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, date DATETIME NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_1FBFB8D962FF6CDF (consultation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, hopital_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, date DATE NOT NULL, heure TIME NOT NULL, message LONGTEXT NOT NULL, INDEX IDX_65E8AA0ACC0FBF92 (hopital_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultat (id INT AUTO_INCREMENT NOT NULL, prescription_id INT DEFAULT NULL, observation LONGTEXT NOT NULL, fichier LONGBLOB NOT NULL, INDEX IDX_E7DB5DE293DB413D (prescription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suivi (id INT AUTO_INCREMENT NOT NULL, consultation_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, dateprise DATETIME NOT NULL, dateretour DATE NOT NULL, timeretour TIME NOT NULL, INDEX IDX_2EBCCA8F62FF6CDF (consultation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE analyse ADD CONSTRAINT FK_351B0C7E93DB413D FOREIGN KEY (prescription_id) REFERENCES prescription (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A66B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A64F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('ALTER TABLE hopital_service ADD CONSTRAINT FK_B55C0308CC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopital (id)');
        $this->addSql('ALTER TABLE hopital_service ADD CONSTRAINT FK_B55C0308ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE hopital_service ADD CONSTRAINT FK_B55C03084F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C93DB413D FOREIGN KEY (prescription_id) REFERENCES prescription (id)');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT FK_1FBFB8D962FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0ACC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopital (id)');
        $this->addSql('ALTER TABLE resultat ADD CONSTRAINT FK_E7DB5DE293DB413D FOREIGN KEY (prescription_id) REFERENCES prescription (id)');
        $this->addSql('ALTER TABLE suivi ADD CONSTRAINT FK_2EBCCA8F62FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id)');
        $this->addSql('ALTER TABLE medecin ADD biographie VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prescription DROP FOREIGN KEY FK_1FBFB8D962FF6CDF');
        $this->addSql('ALTER TABLE suivi DROP FOREIGN KEY FK_2EBCCA8F62FF6CDF');
        $this->addSql('ALTER TABLE hopital_service DROP FOREIGN KEY FK_B55C0308CC0FBF92');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0ACC0FBF92');
        $this->addSql('ALTER TABLE analyse DROP FOREIGN KEY FK_351B0C7E93DB413D');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326C93DB413D');
        $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY FK_E7DB5DE293DB413D');
        $this->addSql('ALTER TABLE hopital_service DROP FOREIGN KEY FK_B55C0308ED5CA9E6');
        $this->addSql('DROP TABLE analyse');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE hopital');
        $this->addSql('DROP TABLE hopital_service');
        $this->addSql('DROP TABLE ordonnance');
        $this->addSql('DROP TABLE prescription');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE resultat');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE suivi');
        $this->addSql('ALTER TABLE medecin DROP biographie');
    }
}
