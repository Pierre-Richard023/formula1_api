<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241108125711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seasons ADD driver_standings_id INT DEFAULT NULL, ADD constructor_standings_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seasons ADD CONSTRAINT FK_B4F4301C5AF4F0CD FOREIGN KEY (driver_standings_id) REFERENCES standings (id)');
        $this->addSql('ALTER TABLE seasons ADD CONSTRAINT FK_B4F4301C34AAA8D7 FOREIGN KEY (constructor_standings_id) REFERENCES standings (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B4F4301C5AF4F0CD ON seasons (driver_standings_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B4F4301C34AAA8D7 ON seasons (constructor_standings_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seasons DROP FOREIGN KEY FK_B4F4301C5AF4F0CD');
        $this->addSql('ALTER TABLE seasons DROP FOREIGN KEY FK_B4F4301C34AAA8D7');
        $this->addSql('DROP INDEX UNIQ_B4F4301C5AF4F0CD ON seasons');
        $this->addSql('DROP INDEX UNIQ_B4F4301C34AAA8D7 ON seasons');
        $this->addSql('ALTER TABLE seasons DROP driver_standings_id, DROP constructor_standings_id');
    }
}
