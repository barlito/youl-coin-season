<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230913191831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Base migration';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE leaderboard (id UUID NOT NULL, season_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_182E52534EC001D1 ON leaderboard (season_id)');
        $this->addSql('CREATE TABLE reward (id UUID NOT NULL, season_id UUID NOT NULL, type VARCHAR(255) NOT NULL, amount INT NOT NULL, status VARCHAR(255) NOT NULL, external_id VARCHAR(255) DEFAULT NULL, rank VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4ED172534EC001D1 ON reward (season_id)');
        $this->addSql('CREATE TABLE season (id UUID NOT NULL, name VARCHAR(255) NOT NULL, date_start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_end TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_score (id UUID NOT NULL, leaderboard_id UUID NOT NULL, score VARCHAR(255) NOT NULL, amount_start VARCHAR(255) NOT NULL, amount_end VARCHAR(255) DEFAULT NULL, wallet_id VARCHAR(255) NOT NULL, discord_user_id VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D05BCC095CE067D8 ON user_score (leaderboard_id)');
        $this->addSql('ALTER TABLE leaderboard ADD CONSTRAINT FK_182E52534EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED172534EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_score ADD CONSTRAINT FK_D05BCC095CE067D8 FOREIGN KEY (leaderboard_id) REFERENCES leaderboard (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE leaderboard DROP CONSTRAINT FK_182E52534EC001D1');
        $this->addSql('ALTER TABLE reward DROP CONSTRAINT FK_4ED172534EC001D1');
        $this->addSql('ALTER TABLE user_score DROP CONSTRAINT FK_D05BCC095CE067D8');
        $this->addSql('DROP TABLE leaderboard');
        $this->addSql('DROP TABLE reward');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE user_score');
    }
}
