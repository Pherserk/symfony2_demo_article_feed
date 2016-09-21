<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160918111528 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_group_user_role (user_group_id INT NOT NULL, user_role_id INT NOT NULL, INDEX IDX_FF87F6CD1ED93D47 (user_group_id), INDEX IDX_FF87F6CD8E0E3CA6 (user_role_id), PRIMARY KEY(user_group_id, user_role_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_group_user_role ADD CONSTRAINT FK_FF87F6CD1ED93D47 FOREIGN KEY (user_group_id) REFERENCES user_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_group_user_role ADD CONSTRAINT FK_FF87F6CD8E0E3CA6 FOREIGN KEY (user_role_id) REFERENCES user_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_group DROP FOREIGN KEY FK_8F02BF9DD60322AC');
        $this->addSql('DROP INDEX IDX_8F02BF9DD60322AC ON user_group');
        $this->addSql('ALTER TABLE user_group DROP role_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_group_user_role');
        $this->addSql('ALTER TABLE user_group ADD role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_group ADD CONSTRAINT FK_8F02BF9DD60322AC FOREIGN KEY (role_id) REFERENCES user_role (id)');
        $this->addSql('CREATE INDEX IDX_8F02BF9DD60322AC ON user_group (role_id)');
    }
}
