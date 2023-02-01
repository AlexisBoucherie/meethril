<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201110142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) DEFAULT NULL, place VARCHAR(255) DEFAULT NULL, date DATETIME DEFAULT NULL, type VARCHAR(150) DEFAULT NULL, max_player_nb INT DEFAULT NULL, current_player_nb INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_session (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, session_id_id INT DEFAULT NULL, user_is_owner TINYINT(1) DEFAULT NULL, pc_name VARCHAR(150) DEFAULT NULL, pc_race VARCHAR(150) DEFAULT NULL, pc_class VARCHAR(150) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8849CBDE9D86650F (user_id_id), INDEX IDX_8849CBDEA4392681 (session_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_session ADD CONSTRAINT FK_8849CBDE9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_session ADD CONSTRAINT FK_8849CBDEA4392681 FOREIGN KEY (session_id_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE user ADD phone_number VARCHAR(25) DEFAULT NULL, ADD username VARCHAR(150) DEFAULT NULL, ADD firstname VARCHAR(150) DEFAULT NULL, ADD lastname VARCHAR(150) DEFAULT NULL, ADD gender VARCHAR(15) DEFAULT NULL, ADD age INT DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD biography LONGTEXT DEFAULT NULL, ADD plays_since VARCHAR(25) DEFAULT NULL, ADD player_or_dm VARCHAR(15) DEFAULT NULL, ADD games VARCHAR(255) DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_session DROP FOREIGN KEY FK_8849CBDE9D86650F');
        $this->addSql('ALTER TABLE user_session DROP FOREIGN KEY FK_8849CBDEA4392681');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE user_session');
        $this->addSql('ALTER TABLE user DROP phone_number, DROP username, DROP firstname, DROP lastname, DROP gender, DROP age, DROP city, DROP biography, DROP plays_since, DROP player_or_dm, DROP games, DROP created_at, DROP updated_at');
    }
}
