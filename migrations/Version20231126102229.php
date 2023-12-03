<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231126102229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146DDEAB1A3');
        $this->addSql('DROP INDEX IDX_6EA9A146DDEAB1A3 ON calendar');
        $this->addSql('ALTER TABLE calendar DROP etudiant_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar ADD etudiant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES useretudiant (id)');
        $this->addSql('CREATE INDEX IDX_6EA9A146DDEAB1A3 ON calendar (etudiant_id)');
    }
}
