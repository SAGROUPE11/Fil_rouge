<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200822114448 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brief_ma_promo (id INT AUTO_INCREMENT NOT NULL, promo_id INT DEFAULT NULL, briefs_id INT DEFAULT NULL, INDEX IDX_6E0C4800D0C07AFF (promo_id), INDEX IDX_6E0C4800CA062D03 (briefs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brief_ma_promo ADD CONSTRAINT FK_6E0C4800D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE brief_ma_promo ADD CONSTRAINT FK_6E0C4800CA062D03 FOREIGN KEY (briefs_id) REFERENCES briefs (id)');
        $this->addSql('DROP TABLE briefs_promo');
        $this->addSql('ALTER TABLE briefs ADD brief_ma_promo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE briefs ADD CONSTRAINT FK_8575E1B857574C78 FOREIGN KEY (brief_ma_promo_id) REFERENCES brief_ma_promo (id)');
        $this->addSql('CREATE INDEX IDX_8575E1B857574C78 ON briefs (brief_ma_promo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE briefs DROP FOREIGN KEY FK_8575E1B857574C78');
        $this->addSql('CREATE TABLE briefs_promo (briefs_id INT NOT NULL, promo_id INT NOT NULL, INDEX IDX_621980D5D0C07AFF (promo_id), INDEX IDX_621980D5CA062D03 (briefs_id), PRIMARY KEY(briefs_id, promo_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE briefs_promo ADD CONSTRAINT FK_621980D5CA062D03 FOREIGN KEY (briefs_id) REFERENCES briefs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE briefs_promo ADD CONSTRAINT FK_621980D5D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE brief_ma_promo');
        $this->addSql('DROP INDEX IDX_8575E1B857574C78 ON briefs');
        $this->addSql('ALTER TABLE briefs DROP brief_ma_promo_id');
    }
}
