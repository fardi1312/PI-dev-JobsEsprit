<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231126134056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A1464CF41933');
        $this->addSql('DROP INDEX UNIQ_6EA9A1464CF41933 ON calendar');
        $this->addSql('ALTER TABLE calendar CHANGE condidature_id candidature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146B6121583 FOREIGN KEY (candidature_id) REFERENCES candidature (id) ON DELETE SET NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6EA9A146B6121583 ON calendar (candidature_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146B6121583');
        $this->addSql('DROP INDEX UNIQ_6EA9A146B6121583 ON calendar');
        $this->addSql('ALTER TABLE calendar CHANGE candidature_id condidature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A1464CF41933 FOREIGN KEY (condidature_id) REFERENCES candidature (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6EA9A1464CF41933 ON calendar (condidature_id)');
    }
}
