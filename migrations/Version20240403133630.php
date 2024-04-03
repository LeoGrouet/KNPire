<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240403133630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Field taskname for TaskEntity changed to name';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_527EDB257CCA9F7B ON task');
        $this->addSql('DROP INDEX UNIQ_527EDB256DE44026 ON task');
        $this->addSql('ALTER TABLE task CHANGE description description VARCHAR(255) NOT NULL, CHANGE taskname name VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_527EDB255E237E06 ON task (name)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_527EDB255E237E06 ON task');
        $this->addSql('ALTER TABLE task CHANGE description description VARCHAR(180) NOT NULL, CHANGE name taskname VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_527EDB257CCA9F7B ON task (taskname)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_527EDB256DE44026 ON task (description)');
    }
}
