<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231018163407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove walletId from userScore entity.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_score DROP wallet_id');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_score ADD wallet_id VARCHAR(255) NOT NULL');
    }
}
