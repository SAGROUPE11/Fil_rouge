<?php

namespace App\Entity;
use App\Entity\Niveau;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\GroupeCompetences;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 * @ApiResource(
 *    normalizationContext={"groups"={"competence:read"}},
 *    collectionOperations={
 *      "get",
 *    "get_competences"={
 *    "method"="GET",
 *    "path"="api/admin/competences",
 *    "shortName"="get_competence",
 *    "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource",
 *     "route_name"="list_competence"
 *                      },
 *    "post_competences"={
 *    "method"="POST",
 *    "path"="api/admin/competences",
 *    "shortName"="post_competence",
 *    "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource",
 *     "route_name"="add_competence"
 *                      }
 *       }, 
 *      itemOperations={
 *     "put","delete","patch","get",
 *    "get_competence_by_id"={
 *    "method"="GET",
 *    "path"="api/admin/competences/{id}",
 *    "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource",
 *    "route_name"="show_competence_by_id",
 *          }
 *      }
 * )
 */
class Competences
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"competence:read", "groupecompetence:read_All","promo:read_CRGrp_C"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le libelle est obligatoire")
     * @Groups({"competence:read", "groupecompetence:read_All","promo:read_CRGrp_C"})
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetences::class, mappedBy="competences")
     */
    private $groupeCompetences;

    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="competence")
     * @Groups({"competence:read", "groupecompetence:read_All"})
     */
    private $niveaux;

    public function __construct()
    {
        $this->groupeCompetences = new ArrayCollection();
        $this->niveaux = new ArrayCollection();
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

    /**
     * @return Collection|GroupeCompetences[]
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->addCompetence($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if ($this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences->removeElement($groupeCompetence);
            $groupeCompetence->removeCompetence($this);
        }

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->setCompetence($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->contains($niveau)) {
            $this->niveaux->removeElement($niveau);
            // set the owning side to null (unless already changed)
            if ($niveau->getCompetence() === $this) {
                $niveau->setCompetence(null);
            }
        }

        return $this;
    }

}
