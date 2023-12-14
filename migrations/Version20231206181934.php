<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231206181934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE week_day_condition DROP CONSTRAINT fk_8d499bf5bf396750');
        $this->addSql('ALTER TABLE max_temperature_condition DROP CONSTRAINT fk_510eb630bf396750');
        $this->addSql('ALTER TABLE date_condition DROP CONSTRAINT fk_82a0bbf7bf396750');
        $this->addSql('ALTER TABLE city_condition DROP CONSTRAINT fk_19829456bf396750');
        $this->addSql('ALTER TABLE date_range_condition DROP CONSTRAINT fk_f4fee066bf396750');
        $this->addSql('ALTER TABLE min_temperature_condition DROP CONSTRAINT fk_6fbb7eb8bf396750');
        $this->addSql('DROP TABLE week_day_condition');
        $this->addSql('DROP TABLE max_temperature_condition');
        $this->addSql('DROP TABLE date_condition');
        $this->addSql('DROP TABLE city_condition');
        $this->addSql('DROP TABLE date_range_condition');
        $this->addSql('DROP TABLE min_temperature_condition');
        $this->addSql('ALTER TABLE condition ADD city VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE condition ADD date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE condition ADD min_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE condition ADD max_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE condition ADD max_temperature INT DEFAULT NULL');
        $this->addSql('ALTER TABLE condition ADD min_temperature INT DEFAULT NULL');
        $this->addSql('ALTER TABLE condition ADD week_day INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE week_day_condition (id INT NOT NULL, week_day INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE max_temperature_condition (id INT NOT NULL, max_temperature INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE date_condition (id INT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE city_condition (id INT NOT NULL, city VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE date_range_condition (id INT NOT NULL, min_date DATE NOT NULL, max_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE min_temperature_condition (id INT NOT NULL, min_temperature INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE week_day_condition ADD CONSTRAINT fk_8d499bf5bf396750 FOREIGN KEY (id) REFERENCES condition (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE max_temperature_condition ADD CONSTRAINT fk_510eb630bf396750 FOREIGN KEY (id) REFERENCES condition (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE date_condition ADD CONSTRAINT fk_82a0bbf7bf396750 FOREIGN KEY (id) REFERENCES condition (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE city_condition ADD CONSTRAINT fk_19829456bf396750 FOREIGN KEY (id) REFERENCES condition (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE date_range_condition ADD CONSTRAINT fk_f4fee066bf396750 FOREIGN KEY (id) REFERENCES condition (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE min_temperature_condition ADD CONSTRAINT fk_6fbb7eb8bf396750 FOREIGN KEY (id) REFERENCES condition (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE condition DROP city');
        $this->addSql('ALTER TABLE condition DROP date');
        $this->addSql('ALTER TABLE condition DROP min_date');
        $this->addSql('ALTER TABLE condition DROP max_date');
        $this->addSql('ALTER TABLE condition DROP max_temperature');
        $this->addSql('ALTER TABLE condition DROP min_temperature');
        $this->addSql('ALTER TABLE condition DROP week_day');
    }
}
