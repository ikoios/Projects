<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241123163446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, way_number INT DEFAULT NULL, address_label VARCHAR(255) DEFAULT NULL, postal_code INT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_list (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_6C377AE7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_users (group_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_44AF8E8EFE54D947 (group_id), INDEX IDX_44AF8E8E67B3B43D (users_id), PRIMARY KEY(group_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, role_type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles_users (roles_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_3D80FB2C38C751C4 (roles_id), INDEX IDX_3D80FB2C67B3B43D (users_id), PRIMARY KEY(roles_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasks (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, state TINYINT(1) DEFAULT NULL, INDEX IDX_50586597F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasks_users (tasks_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_AD0F9E4EE3272D31 (tasks_id), INDEX IDX_AD0F9E4E67B3B43D (users_id), PRIMARY KEY(tasks_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, phone INT DEFAULT NULL, mail VARCHAR(255) DEFAULT NULL, identifier VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, INDEX IDX_1483A5E9F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact_list ADD CONSTRAINT FK_6C377AE7A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE group_users ADD CONSTRAINT FK_44AF8E8EFE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_users ADD CONSTRAINT FK_44AF8E8E67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roles_users ADD CONSTRAINT FK_3D80FB2C38C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roles_users ADD CONSTRAINT FK_3D80FB2C67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE tasks_users ADD CONSTRAINT FK_AD0F9E4EE3272D31 FOREIGN KEY (tasks_id) REFERENCES tasks (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tasks_users ADD CONSTRAINT FK_AD0F9E4E67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_list DROP FOREIGN KEY FK_6C377AE7A76ED395');
        $this->addSql('ALTER TABLE group_users DROP FOREIGN KEY FK_44AF8E8EFE54D947');
        $this->addSql('ALTER TABLE group_users DROP FOREIGN KEY FK_44AF8E8E67B3B43D');
        $this->addSql('ALTER TABLE roles_users DROP FOREIGN KEY FK_3D80FB2C38C751C4');
        $this->addSql('ALTER TABLE roles_users DROP FOREIGN KEY FK_3D80FB2C67B3B43D');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_50586597F5B7AF75');
        $this->addSql('ALTER TABLE tasks_users DROP FOREIGN KEY FK_AD0F9E4EE3272D31');
        $this->addSql('ALTER TABLE tasks_users DROP FOREIGN KEY FK_AD0F9E4E67B3B43D');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9F5B7AF75');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE contact_list');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE group_users');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE roles_users');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('DROP TABLE tasks_users');
        $this->addSql('DROP TABLE users');
    }
}
