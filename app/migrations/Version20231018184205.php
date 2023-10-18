<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231018184205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove userScore amountStart and amountEnd';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_score DROP amount_start');
        $this->addSql('ALTER TABLE user_score DROP amount_end');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_score ADD amount_start VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user_score ADD amount_end VARCHAR(255) DEFAULT NULL');
    }
}
