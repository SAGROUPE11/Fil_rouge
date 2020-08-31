<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeCompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GroupeCompetencesRepository::class)
 * @ApiResource(
 * normalizationContext={"groups"={"groupecompetence:read_All","groupecompetence:read_All"}},
 * collectionOperations=
 * {
 *      "get"=
 *      {
 *          "path"="admin/grpecompetence"
 *      },
 * 
 *      "get_grpecompetence"=
 *      {
 *          "path"="admin/grpecompetence",
 *          "deserialize"=false
 *      },
 * "post"={"path":"/admin/grpecompetences"},
 * "get_grpecompetence"={
 * "methods"="GET",
 * "path"="/admin/grpecompetences",
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="grpecompetence_liste",
 * },
 * "get"={"path":"/admin/grpecompetences/competences"},
 * "get_grpecompetences"={
 * "methods"="GET",
 * "path"="/admin/grpecompetences/competences",
 * "access_control"="(is_granted('ROLE_Admin'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="grpecompetences_liste",
 * },
 * "post_grpecompetence"={
 * "methods"="POST",
 * "path"="/admin/grpecompetences",
 * "access_control"="(is_granted('ROLE_Admin'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="new_grpecompetence",
 * },
 * "get_grpcompetence"={
 * "method"="GET",
 * "path"="/api/admin/referentiels/grpecompetences" ,
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  "route_name"="grpcompetence_liste",
 * },
 * },
 * 
 *  itemOperations={
 * "get_grpeccompetences_by_id"={
 * "method"="GET",
 * "path"="/admin/grpecompetences/{id}" ,
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 *   "delete_grpecompetences_by_id"={
 *  "method"="DELETE",
 *  "path"="/admin/grpecompetences/{id}",
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 *},
 *  "get_grpecompetences_by_id"={
 * "method"="GET",
 * "path"="/admin/grpecompetences/{id}/competences" ,
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * }
 * }
 * )
 */
class GroupeCompetences
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"groupecompetence:read_All","promo:read_CRGrp_C","refgrcomp:read","reference:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le libelle est obligatoire")
     * @Groups({"groupecompetence:read_All","promo:read_CRGrp_C","refgrcomp:read","reference:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le descriptif est obligatoire")
     *  @Groups({"groupecompetence:read_All","promo:read_CRGrp_C","refgrcomp:read","reference:read"})
     */
    private $descriptif;

    /**
     * @ORM\ManyToMany(targetEntity=Competences::class, inversedBy="groupeCompetences",cascade={"persist"})
     *  @Groups({"groupecompetence:read_All","promo:read_CRGrp_C"})
     */
    private $competences;

    /**
     * @ORM\ManyToMany(targetEntity=Referenciel::class, inversedBy="groupeCompetences",cascade={"persist"})
     */
    private $referenciel;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="groupeCompetences",cascade={"persist"})
     */
    private $user;

   

    public function __construct()
    {
        $this->creerCompetence = new ArrayCollection();
        $this->affecter = new ArrayCollection();
        $this->competences = new ArrayCollection();
        $this->referenciel = new ArrayCollection();
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

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * @return Collection|Competences[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competences $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competences $competence): self
    {
        if ($this->competences->contains($competence)) {
            $this->competences->removeElement($competence);
        }

        return $this;
    }

    /**
     * @return Collection|Referenciel[]
     */
    public function getReferenciel(): Collection
    {
        return $this->referenciel;
    }

    public function addReferenciel(Referenciel $referenciel): self
    {
        if (!$this->referenciel->contains($referenciel)) {
            $this->referenciel[] = $referenciel;
        }

        return $this;
    }

    public function removeReferenciel(Referenciel $referenciel): self
    {
        if ($this->referenciel->contains($referenciel)) {
            $this->referenciel->removeElement($referenciel);
        }

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

   

}
