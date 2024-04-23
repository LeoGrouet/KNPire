<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240411123054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP INDEX IDX_527EDB25A76ED395, ADD UNIQUE INDEX UNIQ_527EDB25A76ED395 (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649C4E0A61F ON user (team)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP INDEX UNIQ_527EDB25A76ED395, ADD INDEX IDX_527EDB25A76ED395 (user_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649C4E0A61F ON user');
    }
}
