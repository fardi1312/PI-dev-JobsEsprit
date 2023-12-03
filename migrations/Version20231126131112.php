<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231126131112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar ADD condidature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A1464CF41933 FOREIGN KEY (condidature_id) REFERENCES candidature (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6EA9A1464CF41933 ON calendar (condidature_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A1464CF41933');
        $this->addSql('DROP INDEX UNIQ_6EA9A1464CF41933 ON calendar');
        $this->addSql('ALTER TABLE calendar DROP condidature_id');
    }
}
