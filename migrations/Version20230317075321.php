<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230317075321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acces_deck (id INT AUTO_INCREMENT NOT NULL, deck_id INT NOT NULL, utilisateur_id INT NOT NULL, date_dernier_acces DATETIME NOT NULL, INDEX IDX_66B6B01D111948DC (deck_id), INDEX IDX_66B6B01DFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carte (id INT AUTO_INCREMENT NOT NULL, deck_id INT NOT NULL, question LONGTEXT NOT NULL, reponse LONGTEXT NOT NULL, INDEX IDX_BAD4FFFD111948DC (deck_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, deck_id INT NOT NULL, utilisateur_id INT NOT NULL, message LONGTEXT NOT NULL, date_creation DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_67F068BC111948DC (deck_id), INDEX IDX_67F068BCFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deck (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, utilisateur_id INT DEFAULT NULL, visibilite TINYINT(1) NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, date_creation DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4FAC3637BCF5E72D (categorie_id), INDEX IDX_4FAC3637FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favori (id INT AUTO_INCREMENT NOT NULL, deck_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_EF85A2CC111948DC (deck_id), INDEX IDX_EF85A2CCFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note_deck (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, deck_id INT NOT NULL, note SMALLINT NOT NULL, INDEX IDX_EFD6276FFB88E14F (utilisateur_id), INDEX IDX_EFD6276F111948DC (deck_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position_carte (id INT AUTO_INCREMENT NOT NULL, carte_id INT NOT NULL, utilisateur_id INT NOT NULL, position SMALLINT NOT NULL, INDEX IDX_36141B20C9C7CEB6 (carte_id), INDEX IDX_36141B20FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(50) NOT NULL, pseudo VARCHAR(50) NOT NULL, mail VARCHAR(100) NOT NULL, mdp VARCHAR(255) NOT NULL, date_inscription DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acces_deck ADD CONSTRAINT FK_66B6B01D111948DC FOREIGN KEY (deck_id) REFERENCES deck (id)');
        $this->addSql('ALTER TABLE acces_deck ADD CONSTRAINT FK_66B6B01DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE carte ADD CONSTRAINT FK_BAD4FFFD111948DC FOREIGN KEY (deck_id) REFERENCES deck (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC111948DC FOREIGN KEY (deck_id) REFERENCES deck (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE deck ADD CONSTRAINT FK_4FAC3637BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE deck ADD CONSTRAINT FK_4FAC3637FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CC111948DC FOREIGN KEY (deck_id) REFERENCES deck (id)');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CCFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE note_deck ADD CONSTRAINT FK_EFD6276FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE note_deck ADD CONSTRAINT FK_EFD6276F111948DC FOREIGN KEY (deck_id) REFERENCES deck (id)');
        $this->addSql('ALTER TABLE position_carte ADD CONSTRAINT FK_36141B20C9C7CEB6 FOREIGN KEY (carte_id) REFERENCES carte (id)');
        $this->addSql('ALTER TABLE position_carte ADD CONSTRAINT FK_36141B20FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acces_deck DROP FOREIGN KEY FK_66B6B01D111948DC');
        $this->addSql('ALTER TABLE acces_deck DROP FOREIGN KEY FK_66B6B01DFB88E14F');
        $this->addSql('ALTER TABLE carte DROP FOREIGN KEY FK_BAD4FFFD111948DC');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC111948DC');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCFB88E14F');
        $this->addSql('ALTER TABLE deck DROP FOREIGN KEY FK_4FAC3637BCF5E72D');
        $this->addSql('ALTER TABLE deck DROP FOREIGN KEY FK_4FAC3637FB88E14F');
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CC111948DC');
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CCFB88E14F');
        $this->addSql('ALTER TABLE note_deck DROP FOREIGN KEY FK_EFD6276FFB88E14F');
        $this->addSql('ALTER TABLE note_deck DROP FOREIGN KEY FK_EFD6276F111948DC');
        $this->addSql('ALTER TABLE position_carte DROP FOREIGN KEY FK_36141B20C9C7CEB6');
        $this->addSql('ALTER TABLE position_carte DROP FOREIGN KEY FK_36141B20FB88E14F');
        $this->addSql('DROP TABLE acces_deck');
        $this->addSql('DROP TABLE carte');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE deck');
        $this->addSql('DROP TABLE favori');
        $this->addSql('DROP TABLE note_deck');
        $this->addSql('DROP TABLE position_carte');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
