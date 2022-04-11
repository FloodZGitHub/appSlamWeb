<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220406110026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messagechat ADD userrecoi_id INT NOT NULL, ADD userenvoi_id INT NOT NULL');
        $this->addSql('ALTER TABLE messagechat ADD CONSTRAINT FK_1C361BC34B0EC72 FOREIGN KEY (userrecoi_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE messagechat ADD CONSTRAINT FK_1C361BC13D21392 FOREIGN KEY (userenvoi_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_1C361BC34B0EC72 ON messagechat (userrecoi_id)');
        $this->addSql('CREATE INDEX IDX_1C361BC13D21392 ON messagechat (userenvoi_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messagechat DROP FOREIGN KEY FK_1C361BC34B0EC72');
        $this->addSql('ALTER TABLE messagechat DROP FOREIGN KEY FK_1C361BC13D21392');
        $this->addSql('DROP INDEX IDX_1C361BC34B0EC72 ON messagechat');
        $this->addSql('DROP INDEX IDX_1C361BC13D21392 ON messagechat');
        $this->addSql('ALTER TABLE messagechat DROP userrecoi_id, DROP userenvoi_id');
    }
}
