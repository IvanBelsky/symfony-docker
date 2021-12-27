<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211227194805 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_ip_log (id INT AUTO_INCREMENT NOT NULL, ip_adr VARCHAR(15) NOT NULL, date_created DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_ip_log_user (user_ip_log_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_4B783CAE34415A5E (user_ip_log_id), INDEX IDX_4B783CAEA76ED395 (user_id), PRIMARY KEY(user_ip_log_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_ip_log_user ADD CONSTRAINT FK_4B783CAE34415A5E FOREIGN KEY (user_ip_log_id) REFERENCES user_ip_log (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_ip_log_user ADD CONSTRAINT FK_4B783CAEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(50) NOT NULL, ADD last_name VARCHAR(50) DEFAULT NULL, ADD age SMALLINT NOT NULL, ADD date_created DATE NOT NULL, ADD is_active TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_ip_log_user DROP FOREIGN KEY FK_4B783CAE34415A5E');
        $this->addSql('DROP TABLE user_ip_log');
        $this->addSql('DROP TABLE user_ip_log_user');
        $this->addSql('ALTER TABLE user DROP first_name, DROP last_name, DROP age, DROP date_created, DROP is_active');
    }
}
