<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200822115335 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brief_apprenant (id INT AUTO_INCREMENT NOT NULL, apprenant_id INT DEFAULT NULL, brief_id INT DEFAULT NULL, INDEX IDX_DD6198EDC5697D6D (apprenant_id), INDEX IDX_DD6198ED757FABFF (brief_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brief_apprenant ADD CONSTRAINT FK_DD6198EDC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE brief_apprenant ADD CONSTRAINT FK_DD6198ED757FABFF FOREIGN KEY (brief_id) REFERENCES briefs (id)');
        $this->addSql('DROP TABLE briefs_apprenant');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE briefs_apprenant (briefs_id INT NOT NULL, apprenant_id INT NOT NULL, INDEX IDX_785E3F7C5697D6D (apprenant_id), INDEX IDX_785E3F7CA062D03 (briefs_id), PRIMARY KEY(briefs_id, apprenant_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE briefs_apprenant ADD CONSTRAINT FK_785E3F7C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE briefs_apprenant ADD CONSTRAINT FK_785E3F7CA062D03 FOREIGN KEY (briefs_id) REFERENCES briefs (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE brief_apprenant');
    }
}
