<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201026154640 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stories (id INT AUTO_INCREMENT NOT NULL, cover VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, show_on_site TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stories_lang (id INT AUTO_INCREMENT NOT NULL, story_id INT DEFAULT NULL, slug VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, language VARCHAR(255) NOT NULL, INDEX IDX_A9D1A46DAA5D4036 (story_id), UNIQUE INDEX slug (slug, language), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stories_lang ADD CONSTRAINT FK_A9D1A46DAA5D4036 FOREIGN KEY (story_id) REFERENCES stories (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stories_lang DROP FOREIGN KEY FK_A9D1A46DAA5D4036');
        $this->addSql('DROP TABLE stories');
        $this->addSql('DROP TABLE stories_lang');
    }
}
