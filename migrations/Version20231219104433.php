<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219104433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE api_token_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE condition_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contract_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE opportunity_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE weather_forecast_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE api_token (id INT NOT NULL, owned_by_id INT DEFAULT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, token VARCHAR(68) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7BA2F5EB5E70BCD7 ON api_token (owned_by_id)');
        $this->addSql('COMMENT ON COLUMN api_token.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE condition (id INT NOT NULL, contract_id INT NOT NULL, applies_to VARCHAR(15) NOT NULL, condition_type VARCHAR(255) NOT NULL, week_day INT DEFAULT NULL, min_temperature INT DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, date DATE DEFAULT NULL, min_date DATE DEFAULT NULL, max_date DATE DEFAULT NULL, max_temperature INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BDD688432576E0FD ON condition (contract_id)');
        $this->addSql('CREATE TABLE contract (id INT NOT NULL, owner_id INT NOT NULL, days INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E98F28597E3C61F9 ON contract (owner_id)');
        $this->addSql('CREATE TABLE opportunity (id INT NOT NULL, contract_id INT NOT NULL, from_date DATE NOT NULL, to_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8389C3D72576E0FD ON opportunity (contract_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE weather_forecast (id INT NOT NULL, location VARCHAR(50) NOT NULL, temp_max DOUBLE PRECISION NOT NULL, temp_min DOUBLE PRECISION NOT NULL, temp_mean DOUBLE PRECISION NOT NULL, humidity DOUBLE PRECISION NOT NULL, precip_prob DOUBLE PRECISION NOT NULL, wind_speed DOUBLE PRECISION NOT NULL, cloud_cover DOUBLE PRECISION NOT NULL, uv_index INT NOT NULL, day DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE api_token ADD CONSTRAINT FK_7BA2F5EB5E70BCD7 FOREIGN KEY (owned_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE condition ADD CONSTRAINT FK_BDD688432576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F28597E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D72576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE api_token_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE condition_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contract_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE opportunity_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE weather_forecast_id_seq CASCADE');
        $this->addSql('ALTER TABLE api_token DROP CONSTRAINT FK_7BA2F5EB5E70BCD7');
        $this->addSql('ALTER TABLE condition DROP CONSTRAINT FK_BDD688432576E0FD');
        $this->addSql('ALTER TABLE contract DROP CONSTRAINT FK_E98F28597E3C61F9');
        $this->addSql('ALTER TABLE opportunity DROP CONSTRAINT FK_8389C3D72576E0FD');
        $this->addSql('DROP TABLE api_token');
        $this->addSql('DROP TABLE condition');
        $this->addSql('DROP TABLE contract');
        $this->addSql('DROP TABLE opportunity');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE weather_forecast');
    }
}
