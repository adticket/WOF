<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170705103537 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE `group`');
        $this->addSql('ALTER TABLE groups ADD name VARCHAR(180) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', DROP group_name');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F06D39705E237E06 ON groups (name)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, group_name VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, group_description VARCHAR(1000) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, changed_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP INDEX UNIQ_F06D39705E237E06 ON groups');
        $this->addSql('ALTER TABLE groups ADD group_name VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, DROP name, DROP roles');
    }
}
