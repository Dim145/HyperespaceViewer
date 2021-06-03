<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210603110633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__entry AS SELECT id, identifier, full_name, file_name FROM entry');
        $this->addSql('DROP TABLE entry');
        $this->addSql('CREATE TABLE entry (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, identifier VARCHAR(255) NOT NULL COLLATE BINARY, full_name VARCHAR(255) NOT NULL COLLATE BINARY, file_name VARCHAR(255) NOT NULL COLLATE BINARY, d1 DOUBLE PRECISION NOT NULL, d2 DOUBLE PRECISION NOT NULL, d3 DOUBLE PRECISION NOT NULL, d4 DOUBLE PRECISION NOT NULL, d5 DOUBLE PRECISION NOT NULL, d6 DOUBLE PRECISION NOT NULL, total DOUBLE PRECISION NOT NULL, acquiered_domains INTEGER NOT NULL)');
        $this->addSql('INSERT INTO entry (id, identifier, full_name, file_name) SELECT id, identifier, full_name, file_name FROM __temp__entry');
        $this->addSql('DROP TABLE __temp__entry');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__entry AS SELECT id, identifier, full_name, file_name FROM entry');
        $this->addSql('DROP TABLE entry');
        $this->addSql('CREATE TABLE entry (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, identifier VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, averages CLOB NOT NULL COLLATE BINARY --(DC2Type:array)
        )');
        $this->addSql('INSERT INTO entry (id, identifier, full_name, file_name) SELECT id, identifier, full_name, file_name FROM __temp__entry');
        $this->addSql('DROP TABLE __temp__entry');
    }
}
