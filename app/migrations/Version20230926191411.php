<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230926191411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add unique index to Season status for Unique Active Season.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE UNIQUE INDEX season_unique_active ON season (status) WHERE ((status)::text = \'active\'::text)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX season_unique_active');
    }
}
