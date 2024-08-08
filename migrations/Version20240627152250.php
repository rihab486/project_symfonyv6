<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627152250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_details ADD COLUMN product_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE order_details ADD COLUMN product_description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE order_details ADD COLUMN product_solde_price INTEGER NOT NULL');
        $this->addSql('ALTER TABLE order_details ADD COLUMN product_regular_price INTEGER NOT NULL');
        $this->addSql('ALTER TABLE order_details ADD COLUMN quantity INTEGER NOT NULL');
        $this->addSql('ALTER TABLE order_details ADD COLUMN taxe INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE order_details ADD COLUMN subtotal INTEGER NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__order_details AS SELECT id, my_order_id, updated_at, created_at FROM order_details');
        $this->addSql('DROP TABLE order_details');
        $this->addSql('CREATE TABLE order_details (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, my_order_id INTEGER NOT NULL, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_845CA2C1BFCDF877 FOREIGN KEY (my_order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO order_details (id, my_order_id, updated_at, created_at) SELECT id, my_order_id, updated_at, created_at FROM __temp__order_details');
        $this->addSql('DROP TABLE __temp__order_details');
        $this->addSql('CREATE INDEX IDX_845CA2C1BFCDF877 ON order_details (my_order_id)');
    }
}
