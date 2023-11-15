<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231115040733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_etudiant (id INT AUTO_INCREMENT NOT NULL, phone INT DEFAULT NULL, role VARCHAR(20) NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, age INT DEFAULT NULL, rate DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE covoiturage ADD id_user_etudiant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE covoiturage ADD CONSTRAINT FK_28C79E89977B2DE7 FOREIGN KEY (id_user_etudiant_id) REFERENCES user_etudiant (id)');
        $this->addSql('CREATE INDEX IDX_28C79E89977B2DE7 ON covoiturage (id_user_etudiant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE covoiturage DROP FOREIGN KEY FK_28C79E89977B2DE7');
        $this->addSql('DROP TABLE user_etudiant');
        $this->addSql('DROP INDEX IDX_28C79E89977B2DE7 ON covoiturage');
        $this->addSql('ALTER TABLE covoiturage DROP id_user_etudiant_id');
    }
}
