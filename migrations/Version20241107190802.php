<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107190802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE standings DROP FOREIGN KEY FK_93670F67613FECDF');
        $this->addSql('DROP INDEX UNIQ_93670F67613FECDF ON standings');
        $this->addSql('ALTER TABLE standings DROP session_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE standings ADD session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE standings ADD CONSTRAINT FK_93670F67613FECDF FOREIGN KEY (session_id) REFERENCES sessions (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_93670F67613FECDF ON standings (session_id)');
    }
}
