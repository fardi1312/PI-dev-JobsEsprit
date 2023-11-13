<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231109200013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre ADD entreprise_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FDAC5BE2B FOREIGN KEY (entreprise_id_id) REFERENCES userentreprise (id)');
        $this->addSql('CREATE INDEX IDX_AF86866FDAC5BE2B ON offre (entreprise_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FDAC5BE2B');
        $this->addSql('DROP INDEX IDX_AF86866FDAC5BE2B ON offre');
        $this->addSql('ALTER TABLE offre DROP entreprise_id_id');
    }
}
