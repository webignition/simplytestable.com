<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120831091608CreateCacheValidatorHeaders extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(<<<EOL
          CREATE TABLE CacheValidatorHeaders (
              id INT AUTO_INCREMENT NOT NULL,
              identifier VARCHAR(255) NOT NULL,
              lastModifiedDate DATETIME NOT NULL,
              PRIMARY KEY(id),
              UNIQUE INDEX identifier_idx (identifier)
          )
          DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB
EOL
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql("DROP TABLE CacheValidatorHeaders");
    }
}
