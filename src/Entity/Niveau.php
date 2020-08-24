<?php

namespace App\Entity;

use App\Entity\GroupeCompetences;
use App\Entity\Competences;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=NiveauRepository::class)
 * @ApiResource(
 *    collectionOperations={
 *      "get",
 *    "get_niveau"={
 *    "method"="GET",
 *    "path"="api/admin/niveaux",
 *    "shortName"="get_competence",
 *    "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource",
 *     "route_name"="list_niveau"
 *                      },
 *    "post_niveau"={
 *    "method"="POST",
 *    "path"="api/admin/niveaux",
 *    "shortName"="post_competence",
 *    "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource",
 *     "route_name"="add_niveau"
 *                      }
 *       }, 
 *      itemOperations={
 *     "put","delete","patch","get",
 *    "get_niveau_by_id"={
 *    "method"="GET",
 *    "path"="api/admin/niveaux/{id}",
 *    "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource",
 *    "route_name"="show_niveau_by_id",
 *          },
 *     "put_niveau_by_id"={
 *    "method"="PUT",
 *    "path"="api/admin/niveaux/{id}",
 *    "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource",
 *    "route_name"="edit_niveau_by_id",
 *          }
 *      }
 * )
 */
class Niveau
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"competence:read", "groupecompetence:read_All"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le libelle est obligatoire")
     * @Groups({"competence:read", "groupecompetence:read_All"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Les critetres d'evaluation est obligatoire")
     * @Groups({"competence:read", "groupecompetence:read_All"})
     */
    private $critereEvaluation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le groupe d'action est obligatoire")
     * @Groups({"competence:read", "groupecompetence:read_All"})
     */
    private $groupeAction;

    /**
     * @ORM\ManyToOne(targetEntity=Competences::class, inversedBy="niveaux")
     */
    private $competence;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

        return $this;
    }

    public function getGroupeAction(): ?string
    {
        return $this->groupeAction;
    }

    public function setGroupeAction(string $groupeAction): self
    {
        $this->groupeAction = $groupeAction;

        return $this;
    }

    public function getCompetence(): ?Competences
    {
        return $this->competence;
    }

    public function setCompetence(?Competences $competence): self
    {
        $this->competence = $competence;

        return $this;
    }

    
}
