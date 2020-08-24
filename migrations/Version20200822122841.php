<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200822122841 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brief_groupe (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, brief_id INT DEFAULT NULL, INDEX IDX_5496297B7A45358C (groupe_id), INDEX IDX_5496297B757FABFF (brief_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_livrable (id INT AUTO_INCREMENT NOT NULL, livrable_id INT DEFAULT NULL, brief_id INT DEFAULT NULL, INDEX IDX_7890B21AD0B0DE44 (livrable_id), INDEX IDX_7890B21A757FABFF (brief_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brief_groupe ADD CONSTRAINT FK_5496297B7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE brief_groupe ADD CONSTRAINT FK_5496297B757FABFF FOREIGN KEY (brief_id) REFERENCES briefs (id)');
        $this->addSql('ALTER TABLE brief_livrable ADD CONSTRAINT FK_7890B21AD0B0DE44 FOREIGN KEY (livrable_id) REFERENCES livrables (id)');
        $this->addSql('ALTER TABLE brief_livrable ADD CONSTRAINT FK_7890B21A757FABFF FOREIGN KEY (brief_id) REFERENCES briefs (id)');
        $this->addSql('DROP TABLE briefs_groupe');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE briefs_groupe (briefs_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_D8BD8BF47A45358C (groupe_id), INDEX IDX_D8BD8BF4CA062D03 (briefs_id), PRIMARY KEY(briefs_id, groupe_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE briefs_groupe ADD CONSTRAINT FK_D8BD8BF47A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE briefs_groupe ADD CONSTRAINT FK_D8BD8BF4CA062D03 FOREIGN KEY (briefs_id) REFERENCES briefs (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE brief_groupe');
        $this->addSql('DROP TABLE brief_livrable');
    }
}
