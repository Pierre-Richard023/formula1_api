<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241031165728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE circuits (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, short_name VARCHAR(100) NOT NULL, location VARCHAR(255) NOT NULL, type VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE constructors (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, wolrd_championships INT NOT NULL, race_entries INT NOT NULL, race_wins INT NOT NULL, podiums INT NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE drivers (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, full_name VARCHAR(255) NOT NULL, abbreviation VARCHAR(5) NOT NULL, country VARCHAR(255) NOT NULL, world_championships INT NOT NULL, date_of_birth DATE NOT NULL, place_of_birth VARCHAR(255) NOT NULL, podiums INT NOT NULL, grands_prix_entered INT NOT NULL, race_wins INT NOT NULL, pole_positions INT NOT NULL, nationality VARCHAR(255) NOT NULL, date_of_death DATETIME DEFAULT NULL, permanent_number INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE races (id INT AUTO_INCREMENT NOT NULL, circuit_id INT NOT NULL, season_id INT NOT NULL, name VARCHAR(255) NOT NULL, official_name VARCHAR(255) NOT NULL, race_date DATE NOT NULL, laps INT NOT NULL, distance DOUBLE PRECISION NOT NULL, qualifying_format VARCHAR(100) NOT NULL, INDEX IDX_5DBD1EC9CF2182C8 (circuit_id), INDEX IDX_5DBD1EC94EC001D1 (season_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seasons (id INT AUTO_INCREMENT NOT NULL, year INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sessions (id INT AUTO_INCREMENT NOT NULL, race_id INT NOT NULL, standing_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_9A609D136E59D40D (race_id), UNIQUE INDEX UNIQ_9A609D13346DAB42 (standing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE standing_entry (id INT AUTO_INCREMENT NOT NULL, standings_id INT NOT NULL, driver_id INT DEFAULT NULL, constructor_id INT DEFAULT NULL, position INT DEFAULT NULL, points DOUBLE PRECISION DEFAULT NULL, race_time VARCHAR(50) DEFAULT NULL, INDEX IDX_3FCAE74A7F97F032 (standings_id), INDEX IDX_3FCAE74AC3423909 (driver_id), INDEX IDX_3FCAE74A2D98BF9 (constructor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE standings (id INT AUTO_INCREMENT NOT NULL, season_id INT DEFAULT NULL, INDEX IDX_93670F674EC001D1 (season_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE races ADD CONSTRAINT FK_5DBD1EC9CF2182C8 FOREIGN KEY (circuit_id) REFERENCES circuits (id)');
        $this->addSql('ALTER TABLE races ADD CONSTRAINT FK_5DBD1EC94EC001D1 FOREIGN KEY (season_id) REFERENCES seasons (id)');
        $this->addSql('ALTER TABLE sessions ADD CONSTRAINT FK_9A609D136E59D40D FOREIGN KEY (race_id) REFERENCES races (id)');
        $this->addSql('ALTER TABLE sessions ADD CONSTRAINT FK_9A609D13346DAB42 FOREIGN KEY (standing_id) REFERENCES standings (id)');
        $this->addSql('ALTER TABLE standing_entry ADD CONSTRAINT FK_3FCAE74A7F97F032 FOREIGN KEY (standings_id) REFERENCES standings (id)');
        $this->addSql('ALTER TABLE standing_entry ADD CONSTRAINT FK_3FCAE74AC3423909 FOREIGN KEY (driver_id) REFERENCES drivers (id)');
        $this->addSql('ALTER TABLE standing_entry ADD CONSTRAINT FK_3FCAE74A2D98BF9 FOREIGN KEY (constructor_id) REFERENCES constructors (id)');
        $this->addSql('ALTER TABLE standings ADD CONSTRAINT FK_93670F674EC001D1 FOREIGN KEY (season_id) REFERENCES seasons (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE races DROP FOREIGN KEY FK_5DBD1EC9CF2182C8');
        $this->addSql('ALTER TABLE races DROP FOREIGN KEY FK_5DBD1EC94EC001D1');
        $this->addSql('ALTER TABLE sessions DROP FOREIGN KEY FK_9A609D136E59D40D');
        $this->addSql('ALTER TABLE sessions DROP FOREIGN KEY FK_9A609D13346DAB42');
        $this->addSql('ALTER TABLE standing_entry DROP FOREIGN KEY FK_3FCAE74A7F97F032');
        $this->addSql('ALTER TABLE standing_entry DROP FOREIGN KEY FK_3FCAE74AC3423909');
        $this->addSql('ALTER TABLE standing_entry DROP FOREIGN KEY FK_3FCAE74A2D98BF9');
        $this->addSql('ALTER TABLE standings DROP FOREIGN KEY FK_93670F674EC001D1');
        $this->addSql('DROP TABLE circuits');
        $this->addSql('DROP TABLE constructors');
        $this->addSql('DROP TABLE drivers');
        $this->addSql('DROP TABLE races');
        $this->addSql('DROP TABLE seasons');
        $this->addSql('DROP TABLE sessions');
        $this->addSql('DROP TABLE standing_entry');
        $this->addSql('DROP TABLE standings');
    }
}
