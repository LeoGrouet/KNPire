<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240402092442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add field description in Task table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE task ADD description VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_527EDB256DE44026 ON task (description)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_527EDB256DE44026 ON task');
        $this->addSql('ALTER TABLE task DROP description');
    }
}
