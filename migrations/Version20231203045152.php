<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231203045152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT DEFAULT NULL, candidature_id INT DEFAULT NULL, heure INT NOT NULL, date DATE NOT NULL, INDEX IDX_6EA9A146A4AEAFEA (entreprise_id), UNIQUE INDEX UNIQ_6EA9A146B6121583 (candidature_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidature (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, offre_id INT DEFAULT NULL, cv LONGBLOB NOT NULL, is_treated TINYINT(1) NOT NULL, INDEX IDX_E33BD3B8DDEAB1A3 (etudiant_id), INDEX IDX_E33BD3B84CC8505A (offre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE confirm_covoiturage (id INT AUTO_INCREMENT NOT NULL, covoiturage_id INT DEFAULT NULL, username_etud VARCHAR(255) NOT NULL, username_conducteur VARCHAR(255) NOT NULL, first_name_etud VARCHAR(255) NOT NULL, last_name_etud VARCHAR(255) NOT NULL, first_name_conducteur VARCHAR(255) NOT NULL, last_name_conducteur VARCHAR(255) NOT NULL, phone_etud INT NOT NULL, phone_conducteur INT NOT NULL, email_etud VARCHAR(255) NOT NULL, email_conducteur VARCHAR(255) NOT NULL, heure_depart VARCHAR(255) NOT NULL, lieu_depart VARCHAR(255) NOT NULL, lieu_arrivee VARCHAR(255) NOT NULL, prix_totale_places_reserve INT NOT NULL, nombre_places_reserve INT NOT NULL, confirmed TINYINT(1) NOT NULL, INDEX IDX_204A876562671590 (covoiturage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE covoiturage (id INT AUTO_INCREMENT NOT NULL, id_user_etudiant_id INT DEFAULT NULL, heuredepart VARCHAR(150) NOT NULL, lieudepart VARCHAR(150) NOT NULL, lieuarrivee VARCHAR(150) NOT NULL, prix INT NOT NULL, nombreplacesdisponible INT NOT NULL, image VARCHAR(150) NOT NULL, username VARCHAR(150) NOT NULL, INDEX IDX_28C79E89977B2DE7 (id_user_etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, entrepriseid_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, descreption VARCHAR(255) NOT NULL, type_stage VARCHAR(255) NOT NULL, secteurs VARCHAR(255) NOT NULL, fonction VARCHAR(255) NOT NULL, date_inscription DATE NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_AF86866FA9F4F96B (entrepriseid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_useretudiant (offre_id INT NOT NULL, useretudiant_id INT NOT NULL, INDEX IDX_661ED4D64CC8505A (offre_id), INDEX IDX_661ED4D619C68737 (useretudiant_id), PRIMARY KEY(offre_id, useretudiant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_etudiant (id INT AUTO_INCREMENT NOT NULL, phone INT DEFAULT NULL, role VARCHAR(20) NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, age INT DEFAULT NULL, rate DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE userentreprise (id INT AUTO_INCREMENT NOT NULL, phone INT NOT NULL, role VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, nom_entreprise VARCHAR(255) NOT NULL, localisation VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES userentreprise (id)');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146B6121583 FOREIGN KEY (candidature_id) REFERENCES candidature (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES user_etudiant (id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B84CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE confirm_covoiturage ADD CONSTRAINT FK_204A876562671590 FOREIGN KEY (covoiturage_id) REFERENCES covoiturage (id)');
        $this->addSql('ALTER TABLE covoiturage ADD CONSTRAINT FK_28C79E89977B2DE7 FOREIGN KEY (id_user_etudiant_id) REFERENCES user_etudiant (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FA9F4F96B FOREIGN KEY (entrepriseid_id) REFERENCES userentreprise (id)');
        $this->addSql('ALTER TABLE offre_useretudiant ADD CONSTRAINT FK_661ED4D64CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_useretudiant ADD CONSTRAINT FK_661ED4D619C68737 FOREIGN KEY (useretudiant_id) REFERENCES user_etudiant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146A4AEAFEA');
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146B6121583');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B8DDEAB1A3');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B84CC8505A');
        $this->addSql('ALTER TABLE confirm_covoiturage DROP FOREIGN KEY FK_204A876562671590');
        $this->addSql('ALTER TABLE covoiturage DROP FOREIGN KEY FK_28C79E89977B2DE7');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FA9F4F96B');
        $this->addSql('ALTER TABLE offre_useretudiant DROP FOREIGN KEY FK_661ED4D64CC8505A');
        $this->addSql('ALTER TABLE offre_useretudiant DROP FOREIGN KEY FK_661ED4D619C68737');
        $this->addSql('DROP TABLE calendar');
        $this->addSql('DROP TABLE candidature');
        $this->addSql('DROP TABLE confirm_covoiturage');
        $this->addSql('DROP TABLE covoiturage');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE offre_useretudiant');
        $this->addSql('DROP TABLE user_etudiant');
        $this->addSql('DROP TABLE userentreprise');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
