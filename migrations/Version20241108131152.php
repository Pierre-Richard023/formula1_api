<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241108131152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE standings DROP FOREIGN KEY FK_93670F674EC001D1');
        $this->addSql('DROP INDEX IDX_93670F674EC001D1 ON standings');
        $this->addSql('ALTER TABLE standings DROP season_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE standings ADD season_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE standings ADD CONSTRAINT FK_93670F674EC001D1 FOREIGN KEY (season_id) REFERENCES seasons (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_93670F674EC001D1 ON standings (season_id)');
    }
}
