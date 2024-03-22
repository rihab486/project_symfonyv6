<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240227085239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__page AS SELECT id, title, slug, content, is_head, is_foot, updated_at, created_at FROM page');
        $this->addSql('DROP TABLE page');
        $this->addSql('CREATE TABLE page (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content CLOB NOT NULL, is_head BOOLEAN DEFAULT NULL, is_foot BOOLEAN DEFAULT NULL, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO page (id, title, slug, content, is_head, is_foot, updated_at, created_at) SELECT id, title, slug, content, is_head, is_foot, updated_at, created_at FROM __temp__page');
        $this->addSql('DROP TABLE __temp__page');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__page AS SELECT id, title, content, is_head, is_foot, updated_at, created_at, slug FROM page');
        $this->addSql('DROP TABLE page');
        $this->addSql('CREATE TABLE page (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content CLOB NOT NULL, is_head BOOLEAN DEFAULT NULL, is_foot BOOLEAN DEFAULT NULL, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , slug VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO page (id, title, content, is_head, is_foot, updated_at, created_at, slug) SELECT id, title, content, is_head, is_foot, updated_at, created_at, slug FROM __temp__page');
        $this->addSql('DROP TABLE __temp__page');
    }
}
