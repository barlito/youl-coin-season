<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230911212526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Changes for enums';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE reward ALTER type TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE reward ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE season ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_points RENAME COLUMN points TO score');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE reward ALTER type TYPE SMALLINT');
        $this->addSql('ALTER TABLE reward ALTER status TYPE SMALLINT');
        $this->addSql('ALTER TABLE season ALTER status TYPE SMALLINT');
        $this->addSql('ALTER TABLE user_points RENAME COLUMN score TO points');
    }
}
