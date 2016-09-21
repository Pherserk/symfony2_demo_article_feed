<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160911214914 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE confirmation_pin (id INT AUTO_INCREMENT NOT NULL, pin VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD confirmation_pin_id INT DEFAULT NULL, ADD confirmaton_pin_expiration_date DATETIME NOT NULL, DROP confirmation_pin');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B3C4A29C FOREIGN KEY (confirmation_pin_id) REFERENCES confirmation_pin (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649B3C4A29C ON user (confirmation_pin_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B3C4A29C');
        $this->addSql('DROP TABLE confirmation_pin');
        $this->addSql('DROP INDEX UNIQ_8D93D649B3C4A29C ON user');
        $this->addSql('ALTER TABLE user ADD confirmation_pin VARCHAR(8) NOT NULL COLLATE utf8_unicode_ci, DROP confirmation_pin_id, DROP confirmaton_pin_expiration_date');
    }
}
