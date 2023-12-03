<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231121010335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE confirm_covoiturage (id INT AUTO_INCREMENT NOT NULL, covoiturage_id INT DEFAULT NULL, username_etud VARCHAR(255) NOT NULL, username_conducteur VARCHAR(255) NOT NULL, first_name_etud VARCHAR(255) NOT NULL, last_name_etud VARCHAR(255) NOT NULL, first_name_conducteur VARCHAR(255) NOT NULL, last_name_conducteur VARCHAR(255) NOT NULL, phone_etud INT NOT NULL, phone_conducteur INT NOT NULL, email_etud VARCHAR(255) NOT NULL, email_conducteur VARCHAR(255) NOT NULL, heure_depart VARCHAR(255) NOT NULL, lieu_depart VARCHAR(255) NOT NULL, lieu_arrivee VARCHAR(255) NOT NULL, prix_totale_places_reserve INT NOT NULL, nombre_places_reserve INT NOT NULL, INDEX IDX_204A876562671590 (covoiturage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE covoiturage (id INT AUTO_INCREMENT NOT NULL, id_user_etudiant_id INT DEFAULT NULL, heuredepart VARCHAR(150) NOT NULL, lieudepart VARCHAR(150) NOT NULL, lieuarrivee VARCHAR(150) NOT NULL, prix INT NOT NULL, nombreplacesdisponible INT NOT NULL, image VARCHAR(150) NOT NULL, username VARCHAR(150) NOT NULL, INDEX IDX_28C79E89977B2DE7 (id_user_etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_etudiant (id INT AUTO_INCREMENT NOT NULL, phone INT DEFAULT NULL, role VARCHAR(20) NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, age INT DEFAULT NULL, rate DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE confirm_covoiturage ADD CONSTRAINT FK_204A876562671590 FOREIGN KEY (covoiturage_id) REFERENCES covoiturage (id)');
        $this->addSql('ALTER TABLE covoiturage ADD CONSTRAINT FK_28C79E89977B2DE7 FOREIGN KEY (id_user_etudiant_id) REFERENCES user_etudiant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE confirm_covoiturage DROP FOREIGN KEY FK_204A876562671590');
        $this->addSql('ALTER TABLE covoiturage DROP FOREIGN KEY FK_28C79E89977B2DE7');
        $this->addSql('DROP TABLE confirm_covoiturage');
        $this->addSql('DROP TABLE covoiturage');
        $this->addSql('DROP TABLE user_etudiant');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
