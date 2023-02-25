<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230225122043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rover_camera_rover DROP FOREIGN KEY FK_12C8F83B2236175C');
        $this->addSql('ALTER TABLE rover_camera_rover DROP FOREIGN KEY FK_12C8F83BB58E4CD0');
        $this->addSql('DROP TABLE rover_camera_rover');
        $this->addSql('ALTER TABLE rover_rover_camera ADD CONSTRAINT FK_91BDECD02236175C FOREIGN KEY (rover_id) REFERENCES rover (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rover_rover_camera ADD CONSTRAINT FK_91BDECD0B58E4CD0 FOREIGN KEY (rover_camera_id) REFERENCES rover_camera (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rover_camera_rover (rover_camera_id INT NOT NULL, rover_id INT NOT NULL, INDEX IDX_12C8F83BB58E4CD0 (rover_camera_id), INDEX IDX_12C8F83B2236175C (rover_id), PRIMARY KEY(rover_camera_id, rover_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE rover_camera_rover ADD CONSTRAINT FK_12C8F83B2236175C FOREIGN KEY (rover_id) REFERENCES rover (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rover_camera_rover ADD CONSTRAINT FK_12C8F83BB58E4CD0 FOREIGN KEY (rover_camera_id) REFERENCES rover_camera (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE rover_rover_camera DROP FOREIGN KEY FK_91BDECD02236175C');
        $this->addSql('ALTER TABLE rover_rover_camera DROP FOREIGN KEY FK_91BDECD0B58E4CD0');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
