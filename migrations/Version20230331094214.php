<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331094214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte ADD CONSTRAINT FK_BAD4FFFDEDE09C01 FOREIGN KEY (position_carte_id) REFERENCES position_carte (id)');
        $this->addSql('CREATE INDEX IDX_BAD4FFFDEDE09C01 ON carte (position_carte_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte DROP FOREIGN KEY FK_BAD4FFFDEDE09C01');
        $this->addSql('DROP INDEX IDX_BAD4FFFDEDE09C01 ON carte');
    }
}
