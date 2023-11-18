<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231118125741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE confirm_covoiturage ADD id_covoiturage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE confirm_covoiturage ADD CONSTRAINT FK_204A87655F01A896 FOREIGN KEY (id_covoiturage_id) REFERENCES covoiturage (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_204A87655F01A896 ON confirm_covoiturage (id_covoiturage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE confirm_covoiturage DROP FOREIGN KEY FK_204A87655F01A896');
        $this->addSql('DROP INDEX UNIQ_204A87655F01A896 ON confirm_covoiturage');
        $this->addSql('ALTER TABLE confirm_covoiturage DROP id_covoiturage_id');
    }
}
