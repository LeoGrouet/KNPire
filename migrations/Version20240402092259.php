<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240402092259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Task table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, taskname VARCHAR(180) NOT NULL, points INT NOT NULL, UNIQUE INDEX UNIQ_527EDB257CCA9F7B (taskname), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD task_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6498DB60186 ON user (task_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498DB60186');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP INDEX UNIQ_8D93D6498DB60186 ON user');
        $this->addSql('ALTER TABLE user DROP task_id');
    }
}
