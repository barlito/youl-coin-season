<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230912191242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add reward rank field';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE reward ADD rank VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE reward DROP rank');
    }
}
