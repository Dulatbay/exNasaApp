<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230301075629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, content VARCHAR(255) DEFAULT NULL, INDEX IDX_9474526C9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment_file (id INT AUTO_INCREMENT NOT NULL, comment_id INT DEFAULT NULL, file_id INT DEFAULT NULL, INDEX IDX_AAA994FCF8697D13 (comment_id), UNIQUE INDEX UNIQ_AAA994FC93CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, content_text VARCHAR(255) DEFAULT NULL, INDEX IDX_5A8A6C8D9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_comment (id INT AUTO_INCREMENT NOT NULL, post_id_id INT DEFAULT NULL, comment_id_id INT DEFAULT NULL, INDEX IDX_A99CE55FE85F12B8 (post_id_id), UNIQUE INDEX UNIQ_A99CE55FD6DE06A6 (comment_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_file (id INT AUTO_INCREMENT NOT NULL, file_id INT DEFAULT NULL, post_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_45CA511B93CB796C (file_id), INDEX IDX_45CA511B4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rover (id INT NOT NULL, name VARCHAR(255) NOT NULL, landing_date DATE NOT NULL, launch_date DATE NOT NULL, status VARCHAR(30) NOT NULL, max_sol INT NOT NULL, max_date DATE NOT NULL, total_photos INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rover_rover_camera (rover_id INT NOT NULL, rover_camera_id INT NOT NULL, INDEX IDX_91BDECD02236175C (rover_id), INDEX IDX_91BDECD0B58E4CD0 (rover_camera_id), PRIMARY KEY(rover_id, rover_camera_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rover_camera (id INT NOT NULL, name VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, subscriber_id INT NOT NULL, subscribe_to_id INT DEFAULT NULL, INDEX IDX_A3C664D37808B1AD (subscriber_id), INDEX IDX_A3C664D3188003B6 (subscribe_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(180) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_post (user_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_200B2044A76ED395 (user_id), INDEX IDX_200B20444B89032C (post_id), PRIMARY KEY(user_id, post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment_file ADD CONSTRAINT FK_AAA994FCF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE comment_file ADD CONSTRAINT FK_AAA994FC93CB796C FOREIGN KEY (file_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post_comment ADD CONSTRAINT FK_A99CE55FE85F12B8 FOREIGN KEY (post_id_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE post_comment ADD CONSTRAINT FK_A99CE55FD6DE06A6 FOREIGN KEY (comment_id_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE post_file ADD CONSTRAINT FK_45CA511B93CB796C FOREIGN KEY (file_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE post_file ADD CONSTRAINT FK_45CA511B4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE rover_rover_camera ADD CONSTRAINT FK_91BDECD02236175C FOREIGN KEY (rover_id) REFERENCES rover (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rover_rover_camera ADD CONSTRAINT FK_91BDECD0B58E4CD0 FOREIGN KEY (rover_camera_id) REFERENCES rover_camera (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D37808B1AD FOREIGN KEY (subscriber_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3188003B6 FOREIGN KEY (subscribe_to_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_post ADD CONSTRAINT FK_200B2044A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_post ADD CONSTRAINT FK_200B20444B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9D86650F');
        $this->addSql('ALTER TABLE comment_file DROP FOREIGN KEY FK_AAA994FCF8697D13');
        $this->addSql('ALTER TABLE comment_file DROP FOREIGN KEY FK_AAA994FC93CB796C');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D9D86650F');
        $this->addSql('ALTER TABLE post_comment DROP FOREIGN KEY FK_A99CE55FE85F12B8');
        $this->addSql('ALTER TABLE post_comment DROP FOREIGN KEY FK_A99CE55FD6DE06A6');
        $this->addSql('ALTER TABLE post_file DROP FOREIGN KEY FK_45CA511B93CB796C');
        $this->addSql('ALTER TABLE post_file DROP FOREIGN KEY FK_45CA511B4B89032C');
        $this->addSql('ALTER TABLE rover_rover_camera DROP FOREIGN KEY FK_91BDECD02236175C');
        $this->addSql('ALTER TABLE rover_rover_camera DROP FOREIGN KEY FK_91BDECD0B58E4CD0');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D37808B1AD');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3188003B6');
        $this->addSql('ALTER TABLE user_post DROP FOREIGN KEY FK_200B2044A76ED395');
        $this->addSql('ALTER TABLE user_post DROP FOREIGN KEY FK_200B20444B89032C');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE comment_file');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_comment');
        $this->addSql('DROP TABLE post_file');
        $this->addSql('DROP TABLE rover');
        $this->addSql('DROP TABLE rover_rover_camera');
        $this->addSql('DROP TABLE rover_camera');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_post');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
