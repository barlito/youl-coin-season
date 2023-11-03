<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231102194316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add rank field to UserScore entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_score ADD rank INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_score DROP rank');
    }
}
