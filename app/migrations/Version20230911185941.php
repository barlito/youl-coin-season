<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230911185941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'First migration';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE leaderboard (id UUID NOT NULL, season_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_182E52534EC001D1 ON leaderboard (season_id)');
        $this->addSql('CREATE TABLE reward (id UUID NOT NULL, season_id UUID NOT NULL, type SMALLINT NOT NULL, amount INT NOT NULL, status SMALLINT NOT NULL, external_id VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4ED172534EC001D1 ON reward (season_id)');
        $this->addSql('CREATE TABLE season (id UUID NOT NULL, name VARCHAR(255) NOT NULL, date_start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_end TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_points (id UUID NOT NULL, leaderboard_id UUID NOT NULL, points VARCHAR(255) NOT NULL, amount_start VARCHAR(255) NOT NULL, amount_end VARCHAR(255) DEFAULT NULL, wallet_id VARCHAR(255) NOT NULL, discord_user_id VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_42E895145CE067D8 ON user_points (leaderboard_id)');
        $this->addSql('ALTER TABLE leaderboard ADD CONSTRAINT FK_182E52534EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED172534EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_points ADD CONSTRAINT FK_42E895145CE067D8 FOREIGN KEY (leaderboard_id) REFERENCES leaderboard (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE leaderboard DROP CONSTRAINT FK_182E52534EC001D1');
        $this->addSql('ALTER TABLE reward DROP CONSTRAINT FK_4ED172534EC001D1');
        $this->addSql('ALTER TABLE user_points DROP CONSTRAINT FK_42E895145CE067D8');
        $this->addSql('DROP TABLE leaderboard');
        $this->addSql('DROP TABLE reward');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE user_points');
    }
}
