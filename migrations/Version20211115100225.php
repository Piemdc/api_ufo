<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211115100225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, published_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE besoin (id INT AUTO_INCREMENT NOT NULL, evenement_id_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, quantite INT NOT NULL, reste INT NOT NULL, icone INT DEFAULT NULL, INDEX IDX_8118E811ECEE32AF (evenement_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dispo (id INT AUTO_INCREMENT NOT NULL, evenement_id_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, quantite INT NOT NULL, reste INT NOT NULL, icone INT DEFAULT NULL, INDEX IDX_483B4D2FECEE32AF (evenement_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, creator_id_id INT NOT NULL, nom VARCHAR(150) NOT NULL, icone INT NOT NULL, adresse VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_B26681EF05788E9 (creator_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, pseudo VARCHAR(50) NOT NULL, nom VARCHAR(80) DEFAULT NULL, prenom VARCHAR(80) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', avatar VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE besoin ADD CONSTRAINT FK_8118E811ECEE32AF FOREIGN KEY (evenement_id_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE dispo ADD CONSTRAINT FK_483B4D2FECEE32AF FOREIGN KEY (evenement_id_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EF05788E9 FOREIGN KEY (creator_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE besoin DROP FOREIGN KEY FK_8118E811ECEE32AF');
        $this->addSql('ALTER TABLE dispo DROP FOREIGN KEY FK_483B4D2FECEE32AF');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EF05788E9');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE besoin');
        $this->addSql('DROP TABLE dispo');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE user');
    }
}
