<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190505123622 extends AbstractMigration {
    public function up(Schema $schema):void {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE news ADD COLUMN deleted_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema):void {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__news AS SELECT id, created, title, thumbnail, image, url, text FROM news');
        $this->addSql('DROP TABLE news');
        $this->addSql('CREATE TABLE news (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created DATETIME NOT NULL, title VARCHAR(255) NOT NULL, thumbnail VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, text CLOB NOT NULL)');
        $this->addSql('INSERT INTO news (id, created, title, thumbnail, image, url, text) SELECT id, created, title, thumbnail, image, url, text FROM __temp__news');
        $this->addSql('DROP TABLE __temp__news');
    }
}
