<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231113170540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_profile (id INT AUTO_INCREMENT NOT NULL, bio VARCHAR(255) DEFAULT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_entreprise ADD idprofile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_entreprise ADD CONSTRAINT FK_AA7E3C8C1530F82 FOREIGN KEY (idprofile_id) REFERENCES user_profile (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AA7E3C8C1530F82 ON user_entreprise (idprofile_id)');
        $this->addSql('ALTER TABLE user_etudiant ADD idprofile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_etudiant ADD CONSTRAINT FK_91F3C6E31530F82 FOREIGN KEY (idprofile_id) REFERENCES user_profile (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_91F3C6E31530F82 ON user_etudiant (idprofile_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_entreprise DROP FOREIGN KEY FK_AA7E3C8C1530F82');
        $this->addSql('ALTER TABLE user_etudiant DROP FOREIGN KEY FK_91F3C6E31530F82');
        $this->addSql('DROP TABLE user_profile');
        $this->addSql('DROP INDEX UNIQ_AA7E3C8C1530F82 ON user_entreprise');
        $this->addSql('ALTER TABLE user_entreprise DROP idprofile_id');
        $this->addSql('DROP INDEX UNIQ_91F3C6E31530F82 ON user_etudiant');
        $this->addSql('ALTER TABLE user_etudiant DROP idprofile_id');
    }
}
