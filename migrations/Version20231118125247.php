<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231118125247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE confirm_covoiturage (id INT AUTO_INCREMENT NOT NULL, username_etud VARCHAR(255) NOT NULL, username_conducteur VARCHAR(255) NOT NULL, first_name_etud VARCHAR(255) NOT NULL, last_name_etud VARCHAR(255) NOT NULL, first_name_conducteur VARCHAR(255) NOT NULL, last_name_conducteur VARCHAR(255) NOT NULL, phone_etud INT NOT NULL, phone_conducteur INT NOT NULL, email_etud VARCHAR(255) NOT NULL, email_conducteur VARCHAR(255) NOT NULL, heure_depart VARCHAR(255) NOT NULL, lieu_depart VARCHAR(255) NOT NULL, lieu_arrivee VARCHAR(255) NOT NULL, prix_totale_places_reserve NUMERIC(10, 2) NOT NULL, nombre_places_reserve INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE confirm_covoiturage');
    }
}
