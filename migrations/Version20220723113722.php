<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220723113722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_aide ADD formulaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande_aide ADD CONSTRAINT FK_BE34F6745053569B FOREIGN KEY (formulaire_id) REFERENCES formulaire (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BE34F6745053569B ON demande_aide (formulaire_id)');
        $this->addSql('ALTER TABLE formulaire ADD demandeaide_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formulaire ADD CONSTRAINT FK_5BDD01A8DD6BAD4F FOREIGN KEY (demandeaide_id) REFERENCES demande_aide (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5BDD01A8DD6BAD4F ON formulaire (demandeaide_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_aide DROP FOREIGN KEY FK_BE34F6745053569B');
        $this->addSql('DROP INDEX UNIQ_BE34F6745053569B ON demande_aide');
        $this->addSql('ALTER TABLE demande_aide DROP formulaire_id');
        $this->addSql('ALTER TABLE formulaire DROP FOREIGN KEY FK_5BDD01A8DD6BAD4F');
        $this->addSql('DROP INDEX UNIQ_5BDD01A8DD6BAD4F ON formulaire');
        $this->addSql('ALTER TABLE formulaire DROP demandeaide_id');
    }
}
