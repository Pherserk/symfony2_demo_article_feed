<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160918105205 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $now = new \DateTime('now');

        $this->addSql(
            sprintf(
                'INSERT INTO user_role (`role`, `created_at`) VALUES(\'ROLE_USER\', \'%s\')',
                $now->format('Ymd H:i:s')
            )
        );

        $this->addSql(
            sprintf(
                'INSERT INTO user_role (`role`, `created_at`) VALUES(\'ROLE_ADMIN\', \'%s\')',
                $now->format('Ymd H:i:s')
            )
        );

        $this->addSql(
            sprintf(
                'INSERT INTO user_role (`role`, `created_at`) VALUES(\'ROLE_ALLOWED_TO_SWITCH\', \'%s\')',
                $now->format('Ymd H:i:s')
            )
        );

        $this->addSql(
            sprintf(
                'INSERT INTO user_role (`role`, `created_at`) VALUES(\'ROLE_SUPER_ADMIN\', \'%s\')',
                $now->format('Ymd H:i:s')
            )
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this-addSql('DELETE FROM user_role WHERE name = \'ROLE_USER\'');
        $this-addSql('DELETE FROM user_role WHERE name = \'ROLE_ADMIN\'');
        $this-addSql('DELETE FROM user_role WHERE name = \'ROLE_ALLOWED_TO_SWITCH\'');
        $this-addSql('DELETE FROM user_role WHERE name = \'ROLE_SUPER_ADMIN\'');
    }
}
