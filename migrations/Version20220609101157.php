<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220609101157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Omdbid nullable';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ALTER state DROP DEFAULT');
        $this->addSql('ALTER TABLE movie ALTER omdb_id DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book ALTER state SET DEFAULT \'waiting\'');
        $this->addSql('ALTER TABLE movie ALTER omdb_id SET NOT NULL');
    }
}
