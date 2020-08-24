<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200822015455 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE briefs (id INT AUTO_INCREMENT NOT NULL, formateurs_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, enonce VARCHAR(255) NOT NULL, contexte VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, date_echeance DATE NOT NULL, etat VARCHAR(255) NOT NULL, INDEX IDX_8575E1B8FB0881C8 (formateurs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE briefs_promo (briefs_id INT NOT NULL, promo_id INT NOT NULL, INDEX IDX_621980D5CA062D03 (briefs_id), INDEX IDX_621980D5D0C07AFF (promo_id), PRIMARY KEY(briefs_id, promo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE briefs_tag (briefs_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_F19E8887CA062D03 (briefs_id), INDEX IDX_F19E8887BAD26311 (tag_id), PRIMARY KEY(briefs_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE briefs_niveau (briefs_id INT NOT NULL, niveau_id INT NOT NULL, INDEX IDX_97DBF4BECA062D03 (briefs_id), INDEX IDX_97DBF4BEB3E9C81 (niveau_id), PRIMARY KEY(briefs_id, niveau_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE briefs_apprenant (briefs_id INT NOT NULL, apprenant_id INT NOT NULL, INDEX IDX_785E3F7CA062D03 (briefs_id), INDEX IDX_785E3F7C5697D6D (apprenant_id), PRIMARY KEY(briefs_id, apprenant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE briefs_groupe (briefs_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_D8BD8BF4CA062D03 (briefs_id), INDEX IDX_D8BD8BF47A45358C (groupe_id), PRIMARY KEY(briefs_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_tag (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, is_deleted TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_tag_tag (groupe_tag_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_C430CACFD1EC9F2B (groupe_tag_id), INDEX IDX_C430CACFBAD26311 (tag_id), PRIMARY KEY(groupe_tag_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_partiel (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, lien VARCHAR(255) NOT NULL, fichier VARCHAR(255) NOT NULL, dead_line VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrables (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, dead_line DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrables_briefs (livrables_id INT NOT NULL, briefs_id INT NOT NULL, INDEX IDX_2B04161796108872 (livrables_id), INDEX IDX_2B041617CA062D03 (briefs_id), PRIMARY KEY(livrables_id, briefs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrables_livrable_partiel (livrables_id INT NOT NULL, livrable_partiel_id INT NOT NULL, INDEX IDX_EA5AB4F796108872 (livrables_id), INDEX IDX_EA5AB4F7519178C4 (livrable_partiel_id), PRIMARY KEY(livrables_id, livrable_partiel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrables_apprenant (livrables_id INT NOT NULL, apprenant_id INT NOT NULL, INDEX IDX_6A306A0D96108872 (livrables_id), INDEX IDX_6A306A0DC5697D6D (apprenant_id), PRIMARY KEY(livrables_id, apprenant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, is_deleted TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE briefs ADD CONSTRAINT FK_8575E1B8FB0881C8 FOREIGN KEY (formateurs_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE briefs_promo ADD CONSTRAINT FK_621980D5CA062D03 FOREIGN KEY (briefs_id) REFERENCES briefs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE briefs_promo ADD CONSTRAINT FK_621980D5D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE briefs_tag ADD CONSTRAINT FK_F19E8887CA062D03 FOREIGN KEY (briefs_id) REFERENCES briefs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE briefs_tag ADD CONSTRAINT FK_F19E8887BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE briefs_niveau ADD CONSTRAINT FK_97DBF4BECA062D03 FOREIGN KEY (briefs_id) REFERENCES briefs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE briefs_niveau ADD CONSTRAINT FK_97DBF4BEB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE briefs_apprenant ADD CONSTRAINT FK_785E3F7CA062D03 FOREIGN KEY (briefs_id) REFERENCES briefs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE briefs_apprenant ADD CONSTRAINT FK_785E3F7C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE briefs_groupe ADD CONSTRAINT FK_D8BD8BF4CA062D03 FOREIGN KEY (briefs_id) REFERENCES briefs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE briefs_groupe ADD CONSTRAINT FK_D8BD8BF47A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_tag_tag ADD CONSTRAINT FK_C430CACFD1EC9F2B FOREIGN KEY (groupe_tag_id) REFERENCES groupe_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_tag_tag ADD CONSTRAINT FK_C430CACFBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrables_briefs ADD CONSTRAINT FK_2B04161796108872 FOREIGN KEY (livrables_id) REFERENCES livrables (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrables_briefs ADD CONSTRAINT FK_2B041617CA062D03 FOREIGN KEY (briefs_id) REFERENCES briefs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrables_livrable_partiel ADD CONSTRAINT FK_EA5AB4F796108872 FOREIGN KEY (livrables_id) REFERENCES livrables (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrables_livrable_partiel ADD CONSTRAINT FK_EA5AB4F7519178C4 FOREIGN KEY (livrable_partiel_id) REFERENCES livrable_partiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrables_apprenant ADD CONSTRAINT FK_6A306A0D96108872 FOREIGN KEY (livrables_id) REFERENCES livrables (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrables_apprenant ADD CONSTRAINT FK_6A306A0DC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE briefs_promo DROP FOREIGN KEY FK_621980D5CA062D03');
        $this->addSql('ALTER TABLE briefs_tag DROP FOREIGN KEY FK_F19E8887CA062D03');
        $this->addSql('ALTER TABLE briefs_niveau DROP FOREIGN KEY FK_97DBF4BECA062D03');
        $this->addSql('ALTER TABLE briefs_apprenant DROP FOREIGN KEY FK_785E3F7CA062D03');
        $this->addSql('ALTER TABLE briefs_groupe DROP FOREIGN KEY FK_D8BD8BF4CA062D03');
        $this->addSql('ALTER TABLE livrables_briefs DROP FOREIGN KEY FK_2B041617CA062D03');
        $this->addSql('ALTER TABLE groupe_tag_tag DROP FOREIGN KEY FK_C430CACFD1EC9F2B');
        $this->addSql('ALTER TABLE livrables_livrable_partiel DROP FOREIGN KEY FK_EA5AB4F7519178C4');
        $this->addSql('ALTER TABLE livrables_briefs DROP FOREIGN KEY FK_2B04161796108872');
        $this->addSql('ALTER TABLE livrables_livrable_partiel DROP FOREIGN KEY FK_EA5AB4F796108872');
        $this->addSql('ALTER TABLE livrables_apprenant DROP FOREIGN KEY FK_6A306A0D96108872');
        $this->addSql('ALTER TABLE briefs_tag DROP FOREIGN KEY FK_F19E8887BAD26311');
        $this->addSql('ALTER TABLE groupe_tag_tag DROP FOREIGN KEY FK_C430CACFBAD26311');
        $this->addSql('DROP TABLE briefs');
        $this->addSql('DROP TABLE briefs_promo');
        $this->addSql('DROP TABLE briefs_tag');
        $this->addSql('DROP TABLE briefs_niveau');
        $this->addSql('DROP TABLE briefs_apprenant');
        $this->addSql('DROP TABLE briefs_groupe');
        $this->addSql('DROP TABLE groupe_tag');
        $this->addSql('DROP TABLE groupe_tag_tag');
        $this->addSql('DROP TABLE livrable_partiel');
        $this->addSql('DROP TABLE livrables');
        $this->addSql('DROP TABLE livrables_briefs');
        $this->addSql('DROP TABLE livrables_livrable_partiel');
        $this->addSql('DROP TABLE livrables_apprenant');
        $this->addSql('DROP TABLE tag');
    }
}
