<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231112214718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE useretudiant (id INT AUTO_INCREMENT NOT NULL, phone INT NOT NULL, role VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, age INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calendaractivity ADD etudiant_id_id INT DEFAULT NULL, ADD heure INT NOT NULL');
        $this->addSql('ALTER TABLE calendaractivity ADD CONSTRAINT FK_BA4B93E07EB24B FOREIGN KEY (etudiant_id_id) REFERENCES useretudiant (id)');
        $this->addSql('CREATE INDEX IDX_BA4B93E07EB24B ON calendaractivity (etudiant_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendaractivity DROP FOREIGN KEY FK_BA4B93E07EB24B');
        $this->addSql('DROP TABLE useretudiant');
        $this->addSql('DROP INDEX IDX_BA4B93E07EB24B ON calendaractivity');
        $this->addSql('ALTER TABLE calendaractivity DROP etudiant_id_id, DROP heure');
    }
}
