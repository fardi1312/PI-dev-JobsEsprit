<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204114022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_admin (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B84CC8505A');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B84CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE confirm_covoiturage DROP FOREIGN KEY FK_204A876562671590');
        $this->addSql('ALTER TABLE confirm_covoiturage ADD CONSTRAINT FK_204A876562671590 FOREIGN KEY (covoiturage_id) REFERENCES covoiturage (id)');
        $this->addSql('ALTER TABLE covoiturage DROP FOREIGN KEY FK_28C79E89977B2DE7');
        $this->addSql('ALTER TABLE covoiturage ADD CONSTRAINT FK_28C79E89977B2DE7 FOREIGN KEY (id_user_etudiant_id) REFERENCES useretudiant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_admin');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B84CC8505A');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B84CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON UPDATE SET NULL ON DELETE SET NULL');
        $this->addSql('ALTER TABLE confirm_covoiturage DROP FOREIGN KEY FK_204A876562671590');
        $this->addSql('ALTER TABLE confirm_covoiturage ADD CONSTRAINT FK_204A876562671590 FOREIGN KEY (covoiturage_id) REFERENCES covoiturage (id) ON UPDATE SET NULL ON DELETE SET NULL');
        $this->addSql('ALTER TABLE covoiturage DROP FOREIGN KEY FK_28C79E89977B2DE7');
        $this->addSql('ALTER TABLE covoiturage ADD CONSTRAINT FK_28C79E89977B2DE7 FOREIGN KEY (id_user_etudiant_id) REFERENCES useretudiant (id) ON UPDATE SET NULL ON DELETE SET NULL');
    }
}
