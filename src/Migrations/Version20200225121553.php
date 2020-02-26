<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200225121553 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, mark VARCHAR(255) NOT NULL, number VARCHAR(15) NOT NULL, type VARCHAR(15) NOT NULL, is_delete TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_station (id INT AUTO_INCREMENT NOT NULL, cars_id INT DEFAULT NULL, stations_id INT DEFAULT NULL, quantity INT NOT NULL, date DATE NOT NULL, INDEX IDX_CC92036D8702F506 (cars_id), INDEX IDX_CC92036DB1E3C4B4 (stations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_station ADD CONSTRAINT FK_CC92036D8702F506 FOREIGN KEY (cars_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE car_station ADD CONSTRAINT FK_CC92036DB1E3C4B4 FOREIGN KEY (stations_id) REFERENCES station (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car_station DROP FOREIGN KEY FK_CC92036D8702F506');
        $this->addSql('ALTER TABLE car_station DROP FOREIGN KEY FK_CC92036DB1E3C4B4');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE car_station');
        $this->addSql('DROP TABLE station');
    }
}
