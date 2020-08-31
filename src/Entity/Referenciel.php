<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReferencielRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ReferencielRepository::class)
 * @ApiResource(
 *  normalizationContext={"groups"={"reference:read"}},
 *  collectionOperations={
 * "get_referentiels"={
 * "method"="GET",
 * "path"="/admin/referentiels" ,
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 *  "post_referentiels"={
 * "method"="POST",
 * "path"="api/admin/referentiels",
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="referentiels_write",
 * },
 *  },
 *
 *   itemOperations={
 *  "put","delete","patch","get",
 *   "get"={"path":"/admin/referentiels/{id}","normalization_context"={"groups":"refgrcomp:read"}},
 *   "archivage_referentiel"={
 *    "method"="PUT",
 *    "path"="/admin/referentiels/{id}",
 *    "requirements"={"id"="\d+"},
 *   "controller"=App\Controller\ReferencielController::class
 *  }
 *  },
 * )
 */
class Referenciel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"promo:read_All","groupe:read_All","promo:principal_read","promo:attente_read","promo:read_CRGrp_C","promo_groupe_apprenant:read","promo_formateur:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le libelle est obligatoire")
     * @Groups({"promo:read_All","groupe:read_All","promo:principal_read","promo:attente_read","promo:read_CRGrp_C","promo_groupe_apprenant:read","promo_formateur:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="La presentation est obligatoire")
     * @Groups({"promo:read_All","groupe:read_All","promo:principal_read","promo:attente_read","promo:read_CRGrp_C","promo_groupe_apprenant:read","promo_formateur:read"})
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le programme est obligatoire")
     * @Groups({"promo:read_All","groupe:read_All","promo:principal_read","promo:attente_read","promo:read_CRGrp_C","promo_groupe_apprenant:read","promo_formateur:read"})
     */
    private $programme;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Les criteres d'admission est obligatoire")
     * @Groups({"promo:read_All","groupe:read_All","promo:principal_read","promo:attente_read","promo:read_CRGrp_C","promo_groupe_apprenant:read","promo_formateur:read"})
     */
    private $criteresAdmission;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Les criteres d'evaluation est obligatoire")
     *  @Groups({"promo:read_All","groupe:read_All","promo:principal_read","promo:attente_read","promo:read_CRGrp_C","promo_groupe_apprenant:read","promo_formateur:read"})
     */
    private $criteresEvaluation;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetences::class, mappedBy="referenciel",cascade={"persist"})
     *  @Groups({"promo:read_CRGrp_C"})
     */
    private $groupeCompetences;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, mappedBy="referenciel",cascade = {"persist"})
     */
    private $promos;

    /**
     * @ORM\OneToMany(targetEntity=CompetencesValides::class, mappedBy="referenciel",cascade={"persist"})
     */
    private $competencesValides;


    public function __construct()
    {
        $this->groupeCompetences = new ArrayCollection();
        $this->promos = new ArrayCollection();
        $this->competencesValides = new ArrayCollection();
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

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    public function setProgramme(string $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getCriteresAdmission(): ?string
    {
        return $this->criteresAdmission;
    }

    public function setCriteresAdmission(string $criteresAdmission): self
    {
        $this->criteresAdmission = $criteresAdmission;

        return $this;
    }

    public function getCriteresEvaluation(): ?string
    {
        return $this->criteresEvaluation;
    }

    public function setCriteresEvaluation(string $criteresEvaluation): self
    {
        $this->criteresEvaluation = $criteresEvaluation;

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
            $groupeCompetence->addReferenciel($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if ($this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences->removeElement($groupeCompetence);
            $groupeCompetence->removeReferenciel($this);
        }

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->addReferenciel($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->contains($promo)) {
            $this->promos->removeElement($promo);
            $promo->removeReferenciel($this);
        }

        return $this;
    }

    /**
     * @return Collection|CompetencesValides[]
     */
    public function getCompetencesValides(): Collection
    {
        return $this->competencesValides;
    }

    public function addCompetencesValide(CompetencesValides $competencesValide): self
    {
        if (!$this->competencesValides->contains($competencesValide)) {
            $this->competencesValides[] = $competencesValide;
            $competencesValide->setReferenciel($this);
        }

        return $this;
    }

    public function removeCompetencesValide(CompetencesValides $competencesValide): self
    {
        if ($this->competencesValides->contains($competencesValide)) {
            $this->competencesValides->removeElement($competencesValide);
            // set the owning side to null (unless already changed)
            if ($competencesValide->getReferenciel() === $this) {
                $competencesValide->setReferenciel(null);
            }
        }

        return $this;
    }




}
