<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220718171412 extends AbstractMigration
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
        $this->addSql('CREATE INDEX IDX_BE34F6745053569B ON demande_aide (formulaire_id)');
        $this->addSql('ALTER TABLE formulaire DROP FOREIGN KEY FK_5BDD01A87C4D497E');
        $this->addSql('DROP INDEX UNIQ_5BDD01A87C4D497E ON formulaire');
        $this->addSql('ALTER TABLE formulaire ADD sujet VARCHAR(200) NOT NULL, DROP sujet_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_aide DROP FOREIGN KEY FK_BE34F6745053569B');
        $this->addSql('DROP INDEX IDX_BE34F6745053569B ON demande_aide');
        $this->addSql('ALTER TABLE demande_aide DROP formulaire_id');
        $this->addSql('ALTER TABLE formulaire ADD sujet_id INT DEFAULT NULL, DROP sujet');
        $this->addSql('ALTER TABLE formulaire ADD CONSTRAINT FK_5BDD01A87C4D497E FOREIGN KEY (sujet_id) REFERENCES demande_aide (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5BDD01A87C4D497E ON formulaire (sujet_id)');
    }
}
