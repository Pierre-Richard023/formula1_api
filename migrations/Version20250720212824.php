<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250720212824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE circuits (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, circuits_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, short_name VARCHAR(100) NOT NULL, location VARCHAR(255) NOT NULL, type VARCHAR(20) NOT NULL, INDEX IDX_24A8EC25F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE constructors (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, constructor_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, wolrd_championships INT NOT NULL, race_entries INT NOT NULL, race_wins INT NOT NULL, podiums INT NOT NULL, INDEX IDX_44769E19F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, country_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, demonym VARCHAR(255) DEFAULT NULL, continent VARCHAR(255) NOT NULL, continent_code VARCHAR(5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE drivers (id INT AUTO_INCREMENT NOT NULL, country_of_birth_id INT NOT NULL, nationality_id INT NOT NULL, second_nationality_id INT DEFAULT NULL, driver_id VARCHAR(255) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, full_name VARCHAR(255) NOT NULL, abbreviation VARCHAR(5) NOT NULL, world_championships INT NOT NULL, date_of_birth DATE NOT NULL, place_of_birth VARCHAR(255) NOT NULL, podiums INT NOT NULL, grands_prix_entered INT NOT NULL, race_wins INT NOT NULL, pole_positions INT NOT NULL, date_of_death DATETIME DEFAULT NULL, permanent_number INT DEFAULT NULL, INDEX IDX_E410C3076DE484B2 (country_of_birth_id), INDEX IDX_E410C3071C9DA55 (nationality_id), INDEX IDX_E410C3071AE587A7 (second_nationality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entrants (id INT AUTO_INCREMENT NOT NULL, constructors_id INT NOT NULL, entrants_drivers_id INT DEFAULT NULL, season INT NOT NULL, test_driver TINYINT(1) NOT NULL, races JSON NOT NULL, INDEX IDX_768D504E23122E16 (constructors_id), INDEX IDX_768D504E3D2A7C6E (entrants_drivers_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entrants_drivers (id INT AUTO_INCREMENT NOT NULL, drivers_id INT NOT NULL, INDEX IDX_5B26097B9E6E47B8 (drivers_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE races (id INT AUTO_INCREMENT NOT NULL, circuit_id INT NOT NULL, season_id INT NOT NULL, races_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, official_name VARCHAR(255) NOT NULL, race_date DATE NOT NULL, laps INT NOT NULL, distance DOUBLE PRECISION NOT NULL, qualifying_format VARCHAR(100) NOT NULL, INDEX IDX_5DBD1EC9CF2182C8 (circuit_id), INDEX IDX_5DBD1EC94EC001D1 (season_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seasons (id INT AUTO_INCREMENT NOT NULL, driver_standings_id INT DEFAULT NULL, constructor_standings_id INT DEFAULT NULL, seasons_id VARCHAR(255) NOT NULL, year INT NOT NULL, UNIQUE INDEX UNIQ_B4F4301C5AF4F0CD (driver_standings_id), UNIQUE INDEX UNIQ_B4F4301C34AAA8D7 (constructor_standings_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sessions (id INT AUTO_INCREMENT NOT NULL, race_id INT NOT NULL, standing_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_9A609D136E59D40D (race_id), UNIQUE INDEX UNIQ_9A609D13346DAB42 (standing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE standing_entry (id INT AUTO_INCREMENT NOT NULL, standings_id INT NOT NULL, driver_id INT DEFAULT NULL, constructor_id INT DEFAULT NULL, position INT DEFAULT NULL, points DOUBLE PRECISION DEFAULT NULL, race_time VARCHAR(50) DEFAULT NULL, INDEX IDX_3FCAE74A7F97F032 (standings_id), INDEX IDX_3FCAE74AC3423909 (driver_id), INDEX IDX_3FCAE74A2D98BF9 (constructor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE standings (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE circuits ADD CONSTRAINT FK_24A8EC25F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE constructors ADD CONSTRAINT FK_44769E19F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE drivers ADD CONSTRAINT FK_E410C3076DE484B2 FOREIGN KEY (country_of_birth_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE drivers ADD CONSTRAINT FK_E410C3071C9DA55 FOREIGN KEY (nationality_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE drivers ADD CONSTRAINT FK_E410C3071AE587A7 FOREIGN KEY (second_nationality_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE entrants ADD CONSTRAINT FK_768D504E23122E16 FOREIGN KEY (constructors_id) REFERENCES constructors (id)');
        $this->addSql('ALTER TABLE entrants ADD CONSTRAINT FK_768D504E3D2A7C6E FOREIGN KEY (entrants_drivers_id) REFERENCES entrants_drivers (id)');
        $this->addSql('ALTER TABLE entrants_drivers ADD CONSTRAINT FK_5B26097B9E6E47B8 FOREIGN KEY (drivers_id) REFERENCES drivers (id)');
        $this->addSql('ALTER TABLE races ADD CONSTRAINT FK_5DBD1EC9CF2182C8 FOREIGN KEY (circuit_id) REFERENCES circuits (id)');
        $this->addSql('ALTER TABLE races ADD CONSTRAINT FK_5DBD1EC94EC001D1 FOREIGN KEY (season_id) REFERENCES seasons (id)');
        $this->addSql('ALTER TABLE seasons ADD CONSTRAINT FK_B4F4301C5AF4F0CD FOREIGN KEY (driver_standings_id) REFERENCES standings (id)');
        $this->addSql('ALTER TABLE seasons ADD CONSTRAINT FK_B4F4301C34AAA8D7 FOREIGN KEY (constructor_standings_id) REFERENCES standings (id)');
        $this->addSql('ALTER TABLE sessions ADD CONSTRAINT FK_9A609D136E59D40D FOREIGN KEY (race_id) REFERENCES races (id)');
        $this->addSql('ALTER TABLE sessions ADD CONSTRAINT FK_9A609D13346DAB42 FOREIGN KEY (standing_id) REFERENCES standings (id)');
        $this->addSql('ALTER TABLE standing_entry ADD CONSTRAINT FK_3FCAE74A7F97F032 FOREIGN KEY (standings_id) REFERENCES standings (id)');
        $this->addSql('ALTER TABLE standing_entry ADD CONSTRAINT FK_3FCAE74AC3423909 FOREIGN KEY (driver_id) REFERENCES drivers (id)');
        $this->addSql('ALTER TABLE standing_entry ADD CONSTRAINT FK_3FCAE74A2D98BF9 FOREIGN KEY (constructor_id) REFERENCES constructors (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE circuits DROP FOREIGN KEY FK_24A8EC25F92F3E70');
        $this->addSql('ALTER TABLE constructors DROP FOREIGN KEY FK_44769E19F92F3E70');
        $this->addSql('ALTER TABLE drivers DROP FOREIGN KEY FK_E410C3076DE484B2');
        $this->addSql('ALTER TABLE drivers DROP FOREIGN KEY FK_E410C3071C9DA55');
        $this->addSql('ALTER TABLE drivers DROP FOREIGN KEY FK_E410C3071AE587A7');
        $this->addSql('ALTER TABLE entrants DROP FOREIGN KEY FK_768D504E23122E16');
        $this->addSql('ALTER TABLE entrants DROP FOREIGN KEY FK_768D504E3D2A7C6E');
        $this->addSql('ALTER TABLE entrants_drivers DROP FOREIGN KEY FK_5B26097B9E6E47B8');
        $this->addSql('ALTER TABLE races DROP FOREIGN KEY FK_5DBD1EC9CF2182C8');
        $this->addSql('ALTER TABLE races DROP FOREIGN KEY FK_5DBD1EC94EC001D1');
        $this->addSql('ALTER TABLE seasons DROP FOREIGN KEY FK_B4F4301C5AF4F0CD');
        $this->addSql('ALTER TABLE seasons DROP FOREIGN KEY FK_B4F4301C34AAA8D7');
        $this->addSql('ALTER TABLE sessions DROP FOREIGN KEY FK_9A609D136E59D40D');
        $this->addSql('ALTER TABLE sessions DROP FOREIGN KEY FK_9A609D13346DAB42');
        $this->addSql('ALTER TABLE standing_entry DROP FOREIGN KEY FK_3FCAE74A7F97F032');
        $this->addSql('ALTER TABLE standing_entry DROP FOREIGN KEY FK_3FCAE74AC3423909');
        $this->addSql('ALTER TABLE standing_entry DROP FOREIGN KEY FK_3FCAE74A2D98BF9');
        $this->addSql('DROP TABLE circuits');
        $this->addSql('DROP TABLE constructors');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE drivers');
        $this->addSql('DROP TABLE entrants');
        $this->addSql('DROP TABLE entrants_drivers');
        $this->addSql('DROP TABLE races');
        $this->addSql('DROP TABLE seasons');
        $this->addSql('DROP TABLE sessions');
        $this->addSql('DROP TABLE standing_entry');
        $this->addSql('DROP TABLE standings');
    }
}
