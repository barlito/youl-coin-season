<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230913211829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Admin entity creation';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE admin (id VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76F85E0677 ON admin (username)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE admin');
    }
}
