<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200813112656 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apprenant_profil_sorties (apprenant_id INT NOT NULL, profil_sorties_id INT NOT NULL, INDEX IDX_D7D3C81FC5697D6D (apprenant_id), INDEX IDX_D7D3C81F2E19944C (profil_sorties_id), PRIMARY KEY(apprenant_id, profil_sorties_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apprenant_groupe (apprenant_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_1D224F8DC5697D6D (apprenant_id), INDEX IDX_1D224F8D7A45358C (groupe_id), PRIMARY KEY(apprenant_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competences (id INT AUTO_INCREMENT NOT NULL, niveau_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_DB2077CEB3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, promo_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, statut VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_4B98C21D0C07AFF (promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_competences (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, descriptif VARCHAR(255) NOT NULL, INDEX IDX_54FD0400A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_competences_competences (groupe_competences_id INT NOT NULL, competences_id INT NOT NULL, INDEX IDX_FF48A1E1C1218EC1 (groupe_competences_id), INDEX IDX_FF48A1E1A660B158 (competences_id), PRIMARY KEY(groupe_competences_id, competences_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_competences_referenciel (groupe_competences_id INT NOT NULL, referenciel_id INT NOT NULL, INDEX IDX_5ECA9920C1218EC1 (groupe_competences_id), INDEX IDX_5ECA992022241379 (referenciel_id), PRIMARY KEY(groupe_competences_id, referenciel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil_sorties (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo (id INT AUTO_INCREMENT NOT NULL, langue VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, lieu VARCHAR(255) NOT NULL, reference VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin_provisoire DATE NOT NULL, fabrique VARCHAR(255) NOT NULL, date_fin_reelle DATE NOT NULL, etat VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo_referenciel (promo_id INT NOT NULL, referenciel_id INT NOT NULL, INDEX IDX_AE45E44DD0C07AFF (promo_id), INDEX IDX_AE45E44D22241379 (referenciel_id), PRIMARY KEY(promo_id, referenciel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referenciel (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, presentation VARCHAR(255) NOT NULL, programme VARCHAR(255) NOT NULL, criteres_admission VARCHAR(255) NOT NULL, criteres_evaluation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apprenant_profil_sorties ADD CONSTRAINT FK_D7D3C81FC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_profil_sorties ADD CONSTRAINT FK_D7D3C81F2E19944C FOREIGN KEY (profil_sorties_id) REFERENCES profil_sorties (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_groupe ADD CONSTRAINT FK_1D224F8DC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_groupe ADD CONSTRAINT FK_1D224F8D7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competences ADD CONSTRAINT FK_DB2077CEB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE groupe_competences ADD CONSTRAINT FK_54FD0400A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE groupe_competences_competences ADD CONSTRAINT FK_FF48A1E1C1218EC1 FOREIGN KEY (groupe_competences_id) REFERENCES groupe_competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competences_competences ADD CONSTRAINT FK_FF48A1E1A660B158 FOREIGN KEY (competences_id) REFERENCES competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competences_referenciel ADD CONSTRAINT FK_5ECA9920C1218EC1 FOREIGN KEY (groupe_competences_id) REFERENCES groupe_competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competences_referenciel ADD CONSTRAINT FK_5ECA992022241379 FOREIGN KEY (referenciel_id) REFERENCES referenciel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_referenciel ADD CONSTRAINT FK_AE45E44DD0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_referenciel ADD CONSTRAINT FK_AE45E44D22241379 FOREIGN KEY (referenciel_id) REFERENCES referenciel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant ADD statut VARCHAR(255) NOT NULL, ADD avatar LONGBLOB NOT NULL');
        $this->addSql('ALTER TABLE formateur_groupe ADD CONSTRAINT FK_2C668E097A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau DROP FOREIGN KEY FK_4BDFF36B15761DAB');
        $this->addSql('DROP INDEX IDX_4BDFF36B15761DAB ON niveau');
        $this->addSql('ALTER TABLE niveau DROP competence_id');
        $this->addSql('ALTER TABLE promo_formateur ADD CONSTRAINT FK_C5BC19F4D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_formateur ADD CONSTRAINT FK_C5BC19F4155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user DROP avatar, CHANGE statut type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe_competences_competences DROP FOREIGN KEY FK_FF48A1E1A660B158');
        $this->addSql('ALTER TABLE apprenant_groupe DROP FOREIGN KEY FK_1D224F8D7A45358C');
        $this->addSql('ALTER TABLE formateur_groupe DROP FOREIGN KEY FK_2C668E097A45358C');
        $this->addSql('ALTER TABLE groupe_competences_competences DROP FOREIGN KEY FK_FF48A1E1C1218EC1');
        $this->addSql('ALTER TABLE groupe_competences_referenciel DROP FOREIGN KEY FK_5ECA9920C1218EC1');
        $this->addSql('ALTER TABLE apprenant_profil_sorties DROP FOREIGN KEY FK_D7D3C81F2E19944C');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21D0C07AFF');
        $this->addSql('ALTER TABLE promo_formateur DROP FOREIGN KEY FK_C5BC19F4D0C07AFF');
        $this->addSql('ALTER TABLE promo_referenciel DROP FOREIGN KEY FK_AE45E44DD0C07AFF');
        $this->addSql('ALTER TABLE groupe_competences_referenciel DROP FOREIGN KEY FK_5ECA992022241379');
        $this->addSql('ALTER TABLE promo_referenciel DROP FOREIGN KEY FK_AE45E44D22241379');
        $this->addSql('DROP TABLE apprenant_profil_sorties');
        $this->addSql('DROP TABLE apprenant_groupe');
        $this->addSql('DROP TABLE cm');
        $this->addSql('DROP TABLE competences');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE groupe_competences');
        $this->addSql('DROP TABLE groupe_competences_competences');
        $this->addSql('DROP TABLE groupe_competences_referenciel');
        $this->addSql('DROP TABLE profil_sorties');
        $this->addSql('DROP TABLE promo');
        $this->addSql('DROP TABLE promo_referenciel');
        $this->addSql('DROP TABLE referenciel');
        $this->addSql('ALTER TABLE apprenant DROP statut, DROP avatar');
        $this->addSql('ALTER TABLE niveau ADD competence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE niveau ADD CONSTRAINT FK_4BDFF36B15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4BDFF36B15761DAB ON niveau (competence_id)');
        $this->addSql('ALTER TABLE promo_formateur DROP FOREIGN KEY FK_C5BC19F4155D8F51');
        $this->addSql('ALTER TABLE user ADD avatar LONGBLOB DEFAULT NULL, CHANGE type statut VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
