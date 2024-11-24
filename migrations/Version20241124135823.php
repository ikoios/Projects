<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241124135823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_users (team_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_D385ECA9296CD8AE (team_id), INDEX IDX_D385ECA967B3B43D (users_id), PRIMARY KEY(team_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE team_users ADD CONSTRAINT FK_D385ECA9296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_users ADD CONSTRAINT FK_D385ECA967B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_users DROP FOREIGN KEY FK_44AF8E8E67B3B43D');
        $this->addSql('ALTER TABLE group_users DROP FOREIGN KEY FK_44AF8E8EFE54D947');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE group_users');
        $this->addSql('ALTER TABLE tasks ADD team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_50586597296CD8AE ON tasks (team_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_50586597296CD8AE');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE group_users (group_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_44AF8E8EFE54D947 (group_id), INDEX IDX_44AF8E8E67B3B43D (users_id), PRIMARY KEY(group_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE group_users ADD CONSTRAINT FK_44AF8E8E67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_users ADD CONSTRAINT FK_44AF8E8EFE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_users DROP FOREIGN KEY FK_D385ECA9296CD8AE');
        $this->addSql('ALTER TABLE team_users DROP FOREIGN KEY FK_D385ECA967B3B43D');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_users');
        $this->addSql('DROP INDEX IDX_50586597296CD8AE ON tasks');
        $this->addSql('ALTER TABLE tasks DROP team_id');
    }
}
