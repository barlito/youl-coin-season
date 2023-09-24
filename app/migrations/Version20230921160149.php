<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230921160149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename Discord Primary key';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE admin DROP CONSTRAINT admin_pkey');
        $this->addSql('ALTER TABLE admin RENAME COLUMN id TO discord_id');
        $this->addSql('ALTER TABLE admin ADD PRIMARY KEY (discord_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX admin_pkey');
        $this->addSql('ALTER TABLE admin RENAME COLUMN discord_id TO id');
        $this->addSql('ALTER TABLE admin ADD PRIMARY KEY (id)');
    }
}
