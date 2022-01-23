<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220119171836 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_ip_log_user');
        $this->addSql('ALTER TABLE user_ip_log ADD user_id INT DEFAULT NULL');
        //$this->addSql('ALTER TABLE user_ip_log ADD CONSTRAINT FK_E1A9AAE0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E1A9AAE0A76ED395 ON user_ip_log (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_ip_log_user (user_ip_log_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_4B783CAE34415A5E (user_ip_log_id), INDEX IDX_4B783CAEA76ED395 (user_id), PRIMARY KEY(user_ip_log_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_ip_log_user ADD CONSTRAINT FK_4B783CAE34415A5E FOREIGN KEY (user_ip_log_id) REFERENCES user_ip_log (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_ip_log_user ADD CONSTRAINT FK_4B783CAEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        //$this->addSql('ALTER TABLE user_ip_log DROP FOREIGN KEY FK_E1A9AAE0A76ED395');
        $this->addSql('DROP INDEX IDX_E1A9AAE0A76ED395 ON user_ip_log');
        $this->addSql('ALTER TABLE user_ip_log DROP user_id');
    }
}
