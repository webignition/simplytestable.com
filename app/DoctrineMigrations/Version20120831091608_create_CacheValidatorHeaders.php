<?php

namespace Application\Migrations;

use SimplyTestable\BaseMigrationsBundle\Migration\BaseMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120831091608_create_CacheValidatorHeaders extends BaseMigration
{
    public function up(Schema $schema)
    {      
        
        $this->statements['mysql'] = array(
            "CREATE TABLE CacheValidatorHeaders (
                id INT AUTO_INCREMENT NOT NULL,
                identifier VARCHAR(255) NOT NULL,
                lastModifiedDate DATETIME NOT NULL,
                PRIMARY KEY(id),
                UNIQUE INDEX identifier_idx (identifier))
                DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB"
        );
        
        $this->statements['sqlite'] = array(
            "CREATE TABLE CacheValidatorHeaders (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                identifier VARCHAR(255) NOT NULL COLLATE NOCASE,
                lastModifiedDate DATETIME NOT NULL)",
            "CREATE UNIQUE INDEX identifier_idx ON CacheValidatorHeaders (identifier)"
        );
        
        parent::up($schema);
    }

    public function down(Schema $schema)
    {
        $this->addCommonStatement("DROP TABLE CacheValidatorHeaders");        
        parent::down($schema);
    }
}
