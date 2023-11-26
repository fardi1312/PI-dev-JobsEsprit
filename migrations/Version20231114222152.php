<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231114222152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP INDEX UNIQ_6EA9A146DDEAB1A3, ADD INDEX IDX_6EA9A146DDEAB1A3 (etudiant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP INDEX IDX_6EA9A146DDEAB1A3, ADD UNIQUE INDEX UNIQ_6EA9A146DDEAB1A3 (etudiant_id)');
    }
}
