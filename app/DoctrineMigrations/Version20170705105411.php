<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170705105411 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0FE54D947');
        $this->addSql('CREATE TABLE fos_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', group_description VARCHAR(1000) NOT NULL, created_at DATETIME NOT NULL, changed_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_4B019DDB5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE groups');
        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0FE54D947');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0FE54D947 FOREIGN KEY (group_id) REFERENCES fos_group (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0FE54D947');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, group_name VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, group_description VARCHAR(1000) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, changed_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groups (id INT AUTO_INCREMENT NOT NULL, group_description VARCHAR(1000) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, changed_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, name VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, roles LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE fos_group');
        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0FE54D947');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0FE54D947 FOREIGN KEY (group_id) REFERENCES groups (id) ON DELETE CASCADE');
    }
}
