<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220718152206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formulaire (id INT AUTO_INCREMENT NOT NULL, piece_id INT DEFAULT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, date DATE NOT NULL, siege VARCHAR(50) NOT NULL, sujet VARCHAR(200) NOT NULL, UNIQUE INDEX UNIQ_5BDD01A8C40FCFA8 (piece_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formulaire ADD CONSTRAINT FK_5BDD01A8C40FCFA8 FOREIGN KEY (piece_id) REFERENCES demande_aide (id)');
        $this->addSql('ALTER TABLE demande_aide DROP photo');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE formulaire');
        $this->addSql('ALTER TABLE demande_aide ADD photo VARCHAR(250) NOT NULL');
    }
}
