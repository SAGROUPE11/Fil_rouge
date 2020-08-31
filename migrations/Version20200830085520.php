<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200830085520 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apprenant (id INT NOT NULL, promo_id INT DEFAULT NULL, adresse VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, avatar LONGBLOB NOT NULL, en_attente TINYINT(1) NOT NULL, INDEX IDX_C4EB462ED0C07AFF (promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apprenant_profil_sorties (apprenant_id INT NOT NULL, profil_sorties_id INT NOT NULL, INDEX IDX_D7D3C81FC5697D6D (apprenant_id), INDEX IDX_D7D3C81F2E19944C (profil_sorties_id), PRIMARY KEY(apprenant_id, profil_sorties_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apprenant_groupe (apprenant_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_1D224F8DC5697D6D (apprenant_id), INDEX IDX_1D224F8D7A45358C (groupe_id), PRIMARY KEY(apprenant_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apprenant_livrable_partielle (id INT AUTO_INCREMENT NOT NULL, apprenant_id INT DEFAULT NULL, livrable_partiel_id INT DEFAULT NULL, delai DATE DEFAULT NULL, etat TINYINT(1) NOT NULL, INDEX IDX_C15093B4C5697D6D (apprenant_id), INDEX IDX_C15093B4519178C4 (livrable_partiel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_apprenant (id INT AUTO_INCREMENT NOT NULL, brief_id INT DEFAULT NULL, apprenant_id INT DEFAULT NULL, INDEX IDX_DD6198ED757FABFF (brief_id), INDEX IDX_DD6198EDC5697D6D (apprenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_groupe (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, brief_id INT DEFAULT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_5496297B7A45358C (groupe_id), INDEX IDX_5496297B757FABFF (brief_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_livrable (id INT AUTO_INCREMENT NOT NULL, livrable_id INT DEFAULT NULL, brief_id INT DEFAULT NULL, INDEX IDX_7890B21AD0B0DE44 (livrable_id), INDEX IDX_7890B21A757FABFF (brief_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_ma_promo (id INT AUTO_INCREMENT NOT NULL, promo_id INT DEFAULT NULL, briefs_id INT DEFAULT NULL, INDEX IDX_6E0C4800D0C07AFF (promo_id), INDEX IDX_6E0C4800CA062D03 (briefs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE briefs (id INT AUTO_INCREMENT NOT NULL, formateurs_id INT DEFAULT NULL, langue VARCHAR(255) NOT NULL, nom_brief VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, contexte VARCHAR(255) NOT NULL, livrable_attendus VARCHAR(255) NOT NULL, modalite_pedagogique VARCHAR(255) NOT NULL, critere_evaluation LONGTEXT NOT NULL, modalite_evaluation LONGTEXT NOT NULL, image_promo LONGBLOB NOT NULL, creation_date DATE NOT NULL, etat VARCHAR(255) NOT NULL, archived TINYINT(1) NOT NULL, INDEX IDX_8575E1B8FB0881C8 (formateurs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE briefs_tag (briefs_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_F19E8887CA062D03 (briefs_id), INDEX IDX_F19E8887BAD26311 (tag_id), PRIMARY KEY(briefs_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE briefs_niveau (briefs_id INT NOT NULL, niveau_id INT NOT NULL, INDEX IDX_97DBF4BECA062D03 (briefs_id), INDEX IDX_97DBF4BEB3E9C81 (niveau_id), PRIMARY KEY(briefs_id, niveau_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE briefs_promo (briefs_id INT NOT NULL, promo_id INT NOT NULL, INDEX IDX_621980D5CA062D03 (briefs_id), INDEX IDX_621980D5D0C07AFF (promo_id), PRIMARY KEY(briefs_id, promo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, promo_id INT DEFAULT NULL, message LONGTEXT NOT NULL, piece_jointes LONGBLOB DEFAULT NULL, creat_at DATETIME NOT NULL, INDEX IDX_659DF2AAA76ED395 (user_id), INDEX IDX_659DF2AAD0C07AFF (promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, fil_de_discution_id INT DEFAULT NULL, formateur_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, INDEX IDX_67F068BC8FB20E9C (fil_de_discution_id), INDEX IDX_67F068BC155D8F51 (formateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competences (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competences_valides (id INT AUTO_INCREMENT NOT NULL, referenciel_id INT DEFAULT NULL, promo_id INT DEFAULT NULL, apprenant_id INT DEFAULT NULL, competences_id INT DEFAULT NULL, niveau1 TINYINT(1) NOT NULL, niveau2 TINYINT(1) NOT NULL, niveau3 TINYINT(1) NOT NULL, INDEX IDX_9EEA096E22241379 (referenciel_id), INDEX IDX_9EEA096ED0C07AFF (promo_id), INDEX IDX_9EEA096EC5697D6D (apprenant_id), INDEX IDX_9EEA096EA660B158 (competences_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fil_de_discution (id INT AUTO_INCREMENT NOT NULL, apprenant_livrable_partielle_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3FF0FEA495111B10 (apprenant_livrable_partielle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formateur (id INT NOT NULL, telephone INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formateur_groupe (formateur_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_2C668E09155D8F51 (formateur_id), INDEX IDX_2C668E097A45358C (groupe_id), PRIMARY KEY(formateur_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, promo_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, statut VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, is_deleted TINYINT(1) NOT NULL, INDEX IDX_4B98C21D0C07AFF (promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_competences (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, descriptif VARCHAR(255) NOT NULL, INDEX IDX_54FD0400A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_competences_competences (groupe_competences_id INT NOT NULL, competences_id INT NOT NULL, INDEX IDX_FF48A1E1C1218EC1 (groupe_competences_id), INDEX IDX_FF48A1E1A660B158 (competences_id), PRIMARY KEY(groupe_competences_id, competences_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_competences_referenciel (groupe_competences_id INT NOT NULL, referenciel_id INT NOT NULL, INDEX IDX_5ECA9920C1218EC1 (groupe_competences_id), INDEX IDX_5ECA992022241379 (referenciel_id), PRIMARY KEY(groupe_competences_id, referenciel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_tag (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, is_deleted TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_tag_tag (groupe_tag_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_C430CACFD1EC9F2B (groupe_tag_id), INDEX IDX_C430CACFBAD26311 (tag_id), PRIMARY KEY(groupe_tag_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_partiel (id INT AUTO_INCREMENT NOT NULL, brief_promo_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, nombre_rendu INT NOT NULL, archived TINYINT(1) NOT NULL, delai DATETIME NOT NULL, INDEX IDX_37F072C53628C869 (brief_promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrables (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, dead_line DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrables_briefs (livrables_id INT NOT NULL, briefs_id INT NOT NULL, INDEX IDX_2B04161796108872 (livrables_id), INDEX IDX_2B041617CA062D03 (briefs_id), PRIMARY KEY(livrables_id, briefs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrables_livrable_partiel (livrables_id INT NOT NULL, livrable_partiel_id INT NOT NULL, INDEX IDX_EA5AB4F796108872 (livrables_id), INDEX IDX_EA5AB4F7519178C4 (livrable_partiel_id), PRIMARY KEY(livrables_id, livrable_partiel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrables_apprenant (livrables_id INT NOT NULL, apprenant_id INT NOT NULL, INDEX IDX_6A306A0D96108872 (livrables_id), INDEX IDX_6A306A0DC5697D6D (apprenant_id), PRIMARY KEY(livrables_id, apprenant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, competence_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, critere_evaluation VARCHAR(255) NOT NULL, groupe_action VARCHAR(255) NOT NULL, INDEX IDX_4BDFF36B15761DAB (competence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_livrable_partielle (id INT AUTO_INCREMENT NOT NULL, livrable_partiel_id INT DEFAULT NULL, niveau_id INT DEFAULT NULL, INDEX IDX_134B97EE519178C4 (livrable_partiel_id), INDEX IDX_134B97EEB3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil_sorties (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo (id INT AUTO_INCREMENT NOT NULL, langue VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, lieu VARCHAR(255) NOT NULL, reference VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin_provisoire DATE NOT NULL, fabrique VARCHAR(255) NOT NULL, date_fin_reelle DATE NOT NULL, etat VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo_formateur (promo_id INT NOT NULL, formateur_id INT NOT NULL, INDEX IDX_C5BC19F4D0C07AFF (promo_id), INDEX IDX_C5BC19F4155D8F51 (formateur_id), PRIMARY KEY(promo_id, formateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo_referenciel (promo_id INT NOT NULL, referenciel_id INT NOT NULL, INDEX IDX_AE45E44DD0C07AFF (promo_id), INDEX IDX_AE45E44D22241379 (referenciel_id), PRIMARY KEY(promo_id, referenciel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referenciel (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, presentation VARCHAR(255) NOT NULL, programme VARCHAR(255) NOT NULL, criteres_admission VARCHAR(255) NOT NULL, criteres_evaluation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, is_deleted TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, profil_id INT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649275ED078 (profil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apprenant ADD CONSTRAINT FK_C4EB462ED0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE apprenant ADD CONSTRAINT FK_C4EB462EBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_profil_sorties ADD CONSTRAINT FK_D7D3C81FC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_profil_sorties ADD CONSTRAINT FK_D7D3C81F2E19944C FOREIGN KEY (profil_sorties_id) REFERENCES profil_sorties (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_groupe ADD CONSTRAINT FK_1D224F8DC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_groupe ADD CONSTRAINT FK_1D224F8D7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_livrable_partielle ADD CONSTRAINT FK_C15093B4C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE apprenant_livrable_partielle ADD CONSTRAINT FK_C15093B4519178C4 FOREIGN KEY (livrable_partiel_id) REFERENCES livrable_partiel (id)');
        $this->addSql('ALTER TABLE brief_apprenant ADD CONSTRAINT FK_DD6198ED757FABFF FOREIGN KEY (brief_id) REFERENCES briefs (id)');
        $this->addSql('ALTER TABLE brief_apprenant ADD CONSTRAINT FK_DD6198EDC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE brief_groupe ADD CONSTRAINT FK_5496297B7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE brief_groupe ADD CONSTRAINT FK_5496297B757FABFF FOREIGN KEY (brief_id) REFERENCES briefs (id)');
        $this->addSql('ALTER TABLE brief_livrable ADD CONSTRAINT FK_7890B21AD0B0DE44 FOREIGN KEY (livrable_id) REFERENCES livrables (id)');
        $this->addSql('ALTER TABLE brief_livrable ADD CONSTRAINT FK_7890B21A757FABFF FOREIGN KEY (brief_id) REFERENCES briefs (id)');
        $this->addSql('ALTER TABLE brief_ma_promo ADD CONSTRAINT FK_6E0C4800D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE brief_ma_promo ADD CONSTRAINT FK_6E0C4800CA062D03 FOREIGN KEY (briefs_id) REFERENCES briefs (id)');
        $this->addSql('ALTER TABLE briefs ADD CONSTRAINT FK_8575E1B8FB0881C8 FOREIGN KEY (formateurs_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE briefs_tag ADD CONSTRAINT FK_F19E8887CA062D03 FOREIGN KEY (briefs_id) REFERENCES briefs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE briefs_tag ADD CONSTRAINT FK_F19E8887BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE briefs_niveau ADD CONSTRAINT FK_97DBF4BECA062D03 FOREIGN KEY (briefs_id) REFERENCES briefs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE briefs_niveau ADD CONSTRAINT FK_97DBF4BEB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE briefs_promo ADD CONSTRAINT FK_621980D5CA062D03 FOREIGN KEY (briefs_id) REFERENCES briefs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE briefs_promo ADD CONSTRAINT FK_621980D5D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AAD0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC8FB20E9C FOREIGN KEY (fil_de_discution_id) REFERENCES fil_de_discution (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE competences_valides ADD CONSTRAINT FK_9EEA096E22241379 FOREIGN KEY (referenciel_id) REFERENCES referenciel (id)');
        $this->addSql('ALTER TABLE competences_valides ADD CONSTRAINT FK_9EEA096ED0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE competences_valides ADD CONSTRAINT FK_9EEA096EC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE competences_valides ADD CONSTRAINT FK_9EEA096EA660B158 FOREIGN KEY (competences_id) REFERENCES competences (id)');
        $this->addSql('ALTER TABLE fil_de_discution ADD CONSTRAINT FK_3FF0FEA495111B10 FOREIGN KEY (apprenant_livrable_partielle_id) REFERENCES apprenant_livrable_partielle (id)');
        $this->addSql('ALTER TABLE formateur ADD CONSTRAINT FK_ED767E4FBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formateur_groupe ADD CONSTRAINT FK_2C668E09155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formateur_groupe ADD CONSTRAINT FK_2C668E097A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE groupe_competences ADD CONSTRAINT FK_54FD0400A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE groupe_competences_competences ADD CONSTRAINT FK_FF48A1E1C1218EC1 FOREIGN KEY (groupe_competences_id) REFERENCES groupe_competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competences_competences ADD CONSTRAINT FK_FF48A1E1A660B158 FOREIGN KEY (competences_id) REFERENCES competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competences_referenciel ADD CONSTRAINT FK_5ECA9920C1218EC1 FOREIGN KEY (groupe_competences_id) REFERENCES groupe_competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competences_referenciel ADD CONSTRAINT FK_5ECA992022241379 FOREIGN KEY (referenciel_id) REFERENCES referenciel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_tag_tag ADD CONSTRAINT FK_C430CACFD1EC9F2B FOREIGN KEY (groupe_tag_id) REFERENCES groupe_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_tag_tag ADD CONSTRAINT FK_C430CACFBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_partiel ADD CONSTRAINT FK_37F072C53628C869 FOREIGN KEY (brief_promo_id) REFERENCES brief_ma_promo (id)');
        $this->addSql('ALTER TABLE livrables_briefs ADD CONSTRAINT FK_2B04161796108872 FOREIGN KEY (livrables_id) REFERENCES livrables (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrables_briefs ADD CONSTRAINT FK_2B041617CA062D03 FOREIGN KEY (briefs_id) REFERENCES briefs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrables_livrable_partiel ADD CONSTRAINT FK_EA5AB4F796108872 FOREIGN KEY (livrables_id) REFERENCES livrables (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrables_livrable_partiel ADD CONSTRAINT FK_EA5AB4F7519178C4 FOREIGN KEY (livrable_partiel_id) REFERENCES livrable_partiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrables_apprenant ADD CONSTRAINT FK_6A306A0D96108872 FOREIGN KEY (livrables_id) REFERENCES livrables (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrables_apprenant ADD CONSTRAINT FK_6A306A0DC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau ADD CONSTRAINT FK_4BDFF36B15761DAB FOREIGN KEY (competence_id) REFERENCES competences (id)');
        $this->addSql('ALTER TABLE niveau_livrable_partielle ADD CONSTRAINT FK_134B97EE519178C4 FOREIGN KEY (livrable_partiel_id) REFERENCES livrable_partiel (id)');
        $this->addSql('ALTER TABLE niveau_livrable_partielle ADD CONSTRAINT FK_134B97EEB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE promo_formateur ADD CONSTRAINT FK_C5BC19F4D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_formateur ADD CONSTRAINT FK_C5BC19F4155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_referenciel ADD CONSTRAINT FK_AE45E44DD0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_referenciel ADD CONSTRAINT FK_AE45E44D22241379 FOREIGN KEY (referenciel_id) REFERENCES referenciel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenant_profil_sorties DROP FOREIGN KEY FK_D7D3C81FC5697D6D');
        $this->addSql('ALTER TABLE apprenant_groupe DROP FOREIGN KEY FK_1D224F8DC5697D6D');
        $this->addSql('ALTER TABLE apprenant_livrable_partielle DROP FOREIGN KEY FK_C15093B4C5697D6D');
        $this->addSql('ALTER TABLE brief_apprenant DROP FOREIGN KEY FK_DD6198EDC5697D6D');
        $this->addSql('ALTER TABLE competences_valides DROP FOREIGN KEY FK_9EEA096EC5697D6D');
        $this->addSql('ALTER TABLE livrables_apprenant DROP FOREIGN KEY FK_6A306A0DC5697D6D');
        $this->addSql('ALTER TABLE fil_de_discution DROP FOREIGN KEY FK_3FF0FEA495111B10');
        $this->addSql('ALTER TABLE livrable_partiel DROP FOREIGN KEY FK_37F072C53628C869');
        $this->addSql('ALTER TABLE brief_apprenant DROP FOREIGN KEY FK_DD6198ED757FABFF');
        $this->addSql('ALTER TABLE brief_groupe DROP FOREIGN KEY FK_5496297B757FABFF');
        $this->addSql('ALTER TABLE brief_livrable DROP FOREIGN KEY FK_7890B21A757FABFF');
        $this->addSql('ALTER TABLE brief_ma_promo DROP FOREIGN KEY FK_6E0C4800CA062D03');
        $this->addSql('ALTER TABLE briefs_tag DROP FOREIGN KEY FK_F19E8887CA062D03');
        $this->addSql('ALTER TABLE briefs_niveau DROP FOREIGN KEY FK_97DBF4BECA062D03');
        $this->addSql('ALTER TABLE briefs_promo DROP FOREIGN KEY FK_621980D5CA062D03');
        $this->addSql('ALTER TABLE livrables_briefs DROP FOREIGN KEY FK_2B041617CA062D03');
        $this->addSql('ALTER TABLE competences_valides DROP FOREIGN KEY FK_9EEA096EA660B158');
        $this->addSql('ALTER TABLE groupe_competences_competences DROP FOREIGN KEY FK_FF48A1E1A660B158');
        $this->addSql('ALTER TABLE niveau DROP FOREIGN KEY FK_4BDFF36B15761DAB');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC8FB20E9C');
        $this->addSql('ALTER TABLE briefs DROP FOREIGN KEY FK_8575E1B8FB0881C8');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC155D8F51');
        $this->addSql('ALTER TABLE formateur_groupe DROP FOREIGN KEY FK_2C668E09155D8F51');
        $this->addSql('ALTER TABLE promo_formateur DROP FOREIGN KEY FK_C5BC19F4155D8F51');
        $this->addSql('ALTER TABLE apprenant_groupe DROP FOREIGN KEY FK_1D224F8D7A45358C');
        $this->addSql('ALTER TABLE brief_groupe DROP FOREIGN KEY FK_5496297B7A45358C');
        $this->addSql('ALTER TABLE formateur_groupe DROP FOREIGN KEY FK_2C668E097A45358C');
        $this->addSql('ALTER TABLE groupe_competences_competences DROP FOREIGN KEY FK_FF48A1E1C1218EC1');
        $this->addSql('ALTER TABLE groupe_competences_referenciel DROP FOREIGN KEY FK_5ECA9920C1218EC1');
        $this->addSql('ALTER TABLE groupe_tag_tag DROP FOREIGN KEY FK_C430CACFD1EC9F2B');
        $this->addSql('ALTER TABLE apprenant_livrable_partielle DROP FOREIGN KEY FK_C15093B4519178C4');
        $this->addSql('ALTER TABLE livrables_livrable_partiel DROP FOREIGN KEY FK_EA5AB4F7519178C4');
        $this->addSql('ALTER TABLE niveau_livrable_partielle DROP FOREIGN KEY FK_134B97EE519178C4');
        $this->addSql('ALTER TABLE brief_livrable DROP FOREIGN KEY FK_7890B21AD0B0DE44');
        $this->addSql('ALTER TABLE livrables_briefs DROP FOREIGN KEY FK_2B04161796108872');
        $this->addSql('ALTER TABLE livrables_livrable_partiel DROP FOREIGN KEY FK_EA5AB4F796108872');
        $this->addSql('ALTER TABLE livrables_apprenant DROP FOREIGN KEY FK_6A306A0D96108872');
        $this->addSql('ALTER TABLE briefs_niveau DROP FOREIGN KEY FK_97DBF4BEB3E9C81');
        $this->addSql('ALTER TABLE niveau_livrable_partielle DROP FOREIGN KEY FK_134B97EEB3E9C81');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649275ED078');
        $this->addSql('ALTER TABLE apprenant_profil_sorties DROP FOREIGN KEY FK_D7D3C81F2E19944C');
        $this->addSql('ALTER TABLE apprenant DROP FOREIGN KEY FK_C4EB462ED0C07AFF');
        $this->addSql('ALTER TABLE brief_ma_promo DROP FOREIGN KEY FK_6E0C4800D0C07AFF');
        $this->addSql('ALTER TABLE briefs_promo DROP FOREIGN KEY FK_621980D5D0C07AFF');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AAD0C07AFF');
        $this->addSql('ALTER TABLE competences_valides DROP FOREIGN KEY FK_9EEA096ED0C07AFF');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21D0C07AFF');
        $this->addSql('ALTER TABLE promo_formateur DROP FOREIGN KEY FK_C5BC19F4D0C07AFF');
        $this->addSql('ALTER TABLE promo_referenciel DROP FOREIGN KEY FK_AE45E44DD0C07AFF');
        $this->addSql('ALTER TABLE competences_valides DROP FOREIGN KEY FK_9EEA096E22241379');
        $this->addSql('ALTER TABLE groupe_competences_referenciel DROP FOREIGN KEY FK_5ECA992022241379');
        $this->addSql('ALTER TABLE promo_referenciel DROP FOREIGN KEY FK_AE45E44D22241379');
        $this->addSql('ALTER TABLE briefs_tag DROP FOREIGN KEY FK_F19E8887BAD26311');
        $this->addSql('ALTER TABLE groupe_tag_tag DROP FOREIGN KEY FK_C430CACFBAD26311');
        $this->addSql('ALTER TABLE apprenant DROP FOREIGN KEY FK_C4EB462EBF396750');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AAA76ED395');
        $this->addSql('ALTER TABLE formateur DROP FOREIGN KEY FK_ED767E4FBF396750');
        $this->addSql('ALTER TABLE groupe_competences DROP FOREIGN KEY FK_54FD0400A76ED395');
        $this->addSql('DROP TABLE apprenant');
        $this->addSql('DROP TABLE apprenant_profil_sorties');
        $this->addSql('DROP TABLE apprenant_groupe');
        $this->addSql('DROP TABLE apprenant_livrable_partielle');
        $this->addSql('DROP TABLE brief_apprenant');
        $this->addSql('DROP TABLE brief_groupe');
        $this->addSql('DROP TABLE brief_livrable');
        $this->addSql('DROP TABLE brief_ma_promo');
        $this->addSql('DROP TABLE briefs');
        $this->addSql('DROP TABLE briefs_tag');
        $this->addSql('DROP TABLE briefs_niveau');
        $this->addSql('DROP TABLE briefs_promo');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE cm');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE competences');
        $this->addSql('DROP TABLE competences_valides');
        $this->addSql('DROP TABLE fil_de_discution');
        $this->addSql('DROP TABLE formateur');
        $this->addSql('DROP TABLE formateur_groupe');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE groupe_competences');
        $this->addSql('DROP TABLE groupe_competences_competences');
        $this->addSql('DROP TABLE groupe_competences_referenciel');
        $this->addSql('DROP TABLE groupe_tag');
        $this->addSql('DROP TABLE groupe_tag_tag');
        $this->addSql('DROP TABLE livrable_partiel');
        $this->addSql('DROP TABLE livrables');
        $this->addSql('DROP TABLE livrables_briefs');
        $this->addSql('DROP TABLE livrables_livrable_partiel');
        $this->addSql('DROP TABLE livrables_apprenant');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE niveau_livrable_partielle');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE profil_sorties');
        $this->addSql('DROP TABLE promo');
        $this->addSql('DROP TABLE promo_formateur');
        $this->addSql('DROP TABLE promo_referenciel');
        $this->addSql('DROP TABLE referenciel');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
    }
}
