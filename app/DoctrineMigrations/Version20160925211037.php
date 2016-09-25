<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160925211037 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_mobile_number_verification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, mobile_number VARCHAR(16) NOT NULL, confirmed_at DATETIME NOT NULL, INDEX IDX_7387C36EA76ED395 (user_id), UNIQUE INDEX mobile_number_user (user_id, mobile_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_email_verification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, email VARCHAR(256) NOT NULL, email_hash VARCHAR(42) NOT NULL, confirmed_at DATETIME NOT NULL, INDEX IDX_A3A6C5A3A76ED395 (user_id), UNIQUE INDEX email_user (user_id, email_hash), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_mobile_number_verification ADD CONSTRAINT FK_7387C36EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_email_verification ADD CONSTRAINT FK_A3A6C5A3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_mobile_number_verification');
        $this->addSql('DROP TABLE user_email_verification');
    }
}
