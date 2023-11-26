<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231126130924 extends AbstractMigration
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
        $this->addSql('ALTER TABLE calendar DROP condidature_id');
        $this->addSql('ALTER TABLE candidature ADD interview_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B855D69D95 FOREIGN KEY (interview_id) REFERENCES calendar (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E33BD3B855D69D95 ON candidature (interview_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar ADD condidature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A1464CF41933 FOREIGN KEY (condidature_id) REFERENCES candidature (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6EA9A1464CF41933 ON calendar (condidature_id)');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B855D69D95');
        $this->addSql('DROP INDEX UNIQ_E33BD3B855D69D95 ON candidature');
        $this->addSql('ALTER TABLE candidature DROP interview_id');
    }
}
