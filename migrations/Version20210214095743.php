<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210214095743 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE building (id VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, num_floors INT NOT NULL, creation_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_E16F61D45E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE elevator (id VARCHAR(255) NOT NULL, building_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, current_floor INT NOT NULL, creation_date DATETIME NOT NULL, busy TINYINT(1) NOT NULL, INDEX IDX_1398EB334D2A7E12 (building_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE report (id VARCHAR(255) NOT NULL, date DATETIME NOT NULL, num_total_traveled_floors INT NOT NULL, num_traveled_floors INT NOT NULL, current_floor INT NOT NULL, creation_date DATETIME NOT NULL, elevator_id VARCHAR(255) NOT NULL, building_id VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sequence (id VARCHAR(255) NOT NULL, elevator_id VARCHAR(255) DEFAULT NULL, from_floor INT NOT NULL, from_request INT NOT NULL, to_floor INT NOT NULL, creation_date DATETIME NOT NULL, INDEX IDX_5286D72B332AFBB (elevator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE elevator ADD CONSTRAINT FK_1398EB334D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
        $this->addSql('ALTER TABLE sequence ADD CONSTRAINT FK_5286D72B332AFBB FOREIGN KEY (elevator_id) REFERENCES elevator (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE elevator DROP FOREIGN KEY FK_1398EB334D2A7E12');
        $this->addSql('ALTER TABLE sequence DROP FOREIGN KEY FK_5286D72B332AFBB');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP TABLE elevator');
        $this->addSql('DROP TABLE report');
        $this->addSql('DROP TABLE sequence');
    }
}
