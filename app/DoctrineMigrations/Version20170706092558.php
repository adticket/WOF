<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170706092558 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fos_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', description VARCHAR(1000) NOT NULL, created_at DATETIME NOT NULL, changed_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, created_by LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', UNIQUE INDEX UNIQ_4B019DDB5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', changed_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_groups (user_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_FF8AB7E0A76ED395 (user_id), INDEX IDX_FF8AB7E0FE54D947 (group_id), PRIMARY KEY(user_id, group_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, changed_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, created_by LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, group_id INT DEFAULT NULL, locationName VARCHAR(255) NOT NULL, website VARCHAR(255) DEFAULT NULL, street VARCHAR(100) DEFAULT NULL, house_no VARCHAR(10) DEFAULT NULL, postcode INT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, changed_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, created_by LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', INDEX IDX_5E9E89CBFE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locations_categories (location_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_5256C72D64D218E (location_id), INDEX IDX_5256C72D12469DE2 (category_id), PRIMARY KEY(location_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0FE54D947 FOREIGN KEY (group_id) REFERENCES fos_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBFE54D947 FOREIGN KEY (group_id) REFERENCES fos_group (id)');
        $this->addSql('ALTER TABLE locations_categories ADD CONSTRAINT FK_5256C72D64D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE locations_categories ADD CONSTRAINT FK_5256C72D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0FE54D947');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBFE54D947');
        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0A76ED395');
        $this->addSql('ALTER TABLE locations_categories DROP FOREIGN KEY FK_5256C72D12469DE2');
        $this->addSql('ALTER TABLE locations_categories DROP FOREIGN KEY FK_5256C72D64D218E');
        $this->addSql('DROP TABLE fos_group');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE users_groups');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE locations_categories');
    }
}
