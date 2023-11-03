<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231103215317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change Reward rank field type from string to int';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE reward ALTER rank TYPE INT USING (rank::INT)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE reward ALTER rank TYPE VARCHAR(255)');
    }
}
