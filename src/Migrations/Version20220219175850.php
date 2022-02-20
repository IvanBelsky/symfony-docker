<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220219175850 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, zipcode VARCHAR(6) DEFAULT NULL, town VARCHAR(15) NOT NULL, street VARCHAR(15) DEFAULT NULL, house INT DEFAULT NULL, flat INT DEFAULT NULL, INDEX IDX_5CECC7BE9D86650F (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_5CECC7BE9D86650F FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_ip_log CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_ip_log ADD CONSTRAINT FK_E1A9AAE0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE address');
        $this->addSql('ALTER TABLE user_ip_log DROP FOREIGN KEY FK_E1A9AAE0A76ED395');
        $this->addSql('ALTER TABLE user_ip_log CHANGE user_id user_id INT NOT NULL');
    }
}
