<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220315100010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_annonce (type_id INT NOT NULL, annonce_id INT NOT NULL, INDEX IDX_DE74FC10C54C8C93 (type_id), INDEX IDX_DE74FC108805AB2F (annonce_id), PRIMARY KEY(type_id, annonce_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE type_annonce ADD CONSTRAINT FK_DE74FC10C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_annonce ADD CONSTRAINT FK_DE74FC108805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5A76ED395 ON annonce (user_id)');
        $this->addSql('ALTER TABLE messagechat ADD userrecu_id INT NOT NULL, ADD userenvoi_id INT NOT NULL');
        $this->addSql('ALTER TABLE messagechat ADD CONSTRAINT FK_1C361BC39B03D3A FOREIGN KEY (userrecu_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE messagechat ADD CONSTRAINT FK_1C361BC13D21392 FOREIGN KEY (userenvoi_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_1C361BC39B03D3A ON messagechat (userrecu_id)');
        $this->addSql('CREATE INDEX IDX_1C361BC13D21392 ON messagechat (userenvoi_id)');
        $this->addSql('ALTER TABLE user ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649A76ED395 ON user (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE type_annonce');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5A76ED395');
        $this->addSql('DROP INDEX IDX_F65593E5A76ED395 ON annonce');
        $this->addSql('ALTER TABLE annonce DROP user_id');
        $this->addSql('ALTER TABLE messagechat DROP FOREIGN KEY FK_1C361BC39B03D3A');
        $this->addSql('ALTER TABLE messagechat DROP FOREIGN KEY FK_1C361BC13D21392');
        $this->addSql('DROP INDEX IDX_1C361BC39B03D3A ON messagechat');
        $this->addSql('DROP INDEX IDX_1C361BC13D21392 ON messagechat');
        $this->addSql('ALTER TABLE messagechat DROP userrecu_id, DROP userenvoi_id');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649A76ED395');
        $this->addSql('DROP INDEX UNIQ_8D93D649A76ED395 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP user_id');
    }
}
