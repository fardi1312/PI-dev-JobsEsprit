<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231114225535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar ADD entreprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES userentreprise (id)');
        $this->addSql('CREATE INDEX IDX_6EA9A146A4AEAFEA ON calendar (entreprise_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146A4AEAFEA');
        $this->addSql('DROP INDEX IDX_6EA9A146A4AEAFEA ON calendar');
        $this->addSql('ALTER TABLE calendar DROP entreprise_id');
    }
}
