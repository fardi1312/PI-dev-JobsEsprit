<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122083649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offre_useretudiant (offre_id INT NOT NULL, useretudiant_id INT NOT NULL, INDEX IDX_661ED4D64CC8505A (offre_id), INDEX IDX_661ED4D619C68737 (useretudiant_id), PRIMARY KEY(offre_id, useretudiant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offre_useretudiant ADD CONSTRAINT FK_661ED4D64CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_useretudiant ADD CONSTRAINT FK_661ED4D619C68737 FOREIGN KEY (useretudiant_id) REFERENCES useretudiant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre_useretudiant DROP FOREIGN KEY FK_661ED4D64CC8505A');
        $this->addSql('ALTER TABLE offre_useretudiant DROP FOREIGN KEY FK_661ED4D619C68737');
        $this->addSql('DROP TABLE offre_useretudiant');
    }
}
