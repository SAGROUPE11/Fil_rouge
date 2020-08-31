<?php

namespace App\Entity;

use App\Entity\Promo;
use DateTimeInterface;
use App\Entity\Apprenant;
use App\Entity\Formateur;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 *  @ApiResource(
 * collectionOperations=
 * {
 *     "get",
 * "get_groupes"={
 * "methods"="GET",
 * "path"="api/admin/groupes",
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="list_groupe"
 *              },
 *   "get_groupes_apps"={
 *  "normalization_context"={"groups":"apprenant:read"},
 * "method"="GET",
 * "path"="/admin/groupes/apprenants" ,
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 *  "post_groupe"={
 * "method"="POST",
 * "path"="api/admin/groupes",
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="groupe_write",
 * },
 * },
 *     itemOperations={
 *     "put","delete","patch","get",
 *    "get_groupe_by_id"={
 *    "method"="GET",
 *    "path"="api/admin/groupes/{id}",
 *    "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource",
 *    "route_name"="show_groupes_by_id",
 *          },
 *  "post_app_gr"={
 * "method"="PUT",
 * "path"="/admin/groupes/{id}",
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="app_gr_write",
 * },
 *   "delete_apprenant"={
 *         "method"="DELETE",
 *         "path"="/groupes/{id_groupe}/apprenants/{id_apprenant}",
 *         "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 *         "access_control_message"="Vous n'avez pas access à cette Ressource",
 *         "route_name"="delete_apprenant_groupe",
 *     }
 *    }
 * )
 */
class Groupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"promo:read_All","promo:principal_read","promo_groupe_apprenant:read","promo_formateur:read","brief_Groupe:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"promo:read_All","promo:principal_read","promo_groupe_apprenant:read","promo_formateur:read","brief_Groupe:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     * @Groups({"promo:read_All","brief_Groupe:read","promo:principal_read","promo_groupe_apprenant:read","promo_formateur:read"})
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"promo:read_All","brief_Groupe:read","promo:principal_read","promo_groupe_apprenant:read","promo_formateur:read"})
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"promo:read_All","brief_Groupe:read","promo:principal_read","promo_groupe_apprenant:read","promo_formateur:read"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupe", cascade={"persist"})
     * @Groups({"groupe:read_All","groupe:read","brief_Groupe:read"})
     */
    private $promo;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, mappedBy="groupe")
     * @Groups({"groupe:read_All","groupe:read","brief_Groupe:read"})
     */
    private $formateurs;
    

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, mappedBy="groupe", cascade={"persist"})
     * @Groups({"groupe:read_All","brief_Groupe:read","promo:principal_read","promo:attente_read","promo_groupe_apprenant:read"})
     */
    private $apprenants;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDeleted=true;

    /**
     * @ORM\OneToMany(targetEntity=BriefGroupe::class, mappedBy="groupe")
     */
    private $briefGroupes;


    public function __construct()
    {
        $this->formateurs = new ArrayCollection();
        $this->apprenants = new ArrayCollection();
        $this->briefGroupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateurs(): Collection
    {
        return $this->formateurs;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateurs->contains($formateur)) {
            $this->formateurs[] = $formateur;
            $formateur->addGroupe($this);
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        if ($this->formateurs->contains($formateur)) {
            $this->formateurs->removeElement($formateur);
            $formateur->removeGroupe($this);
        }

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
            $apprenant->addGroupe($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->contains($apprenant)) {
            $this->apprenants->removeElement($apprenant);
            $apprenant->removeGroupe($this);
        }

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * @return Collection|BriefGroupe[]
     */
    public function getBriefGroupes(): Collection
    {
        return $this->briefGroupes;
    }

    public function addBriefGroupe(BriefGroupe $briefGroupe): self
    {
        if (!$this->briefGroupes->contains($briefGroupe)) {
            $this->briefGroupes[] = $briefGroupe;
            $briefGroupe->setGroupe($this);
        }

        return $this;
    }

    public function removeBriefGroupe(BriefGroupe $briefGroupe): self
    {
        if ($this->briefGroupes->contains($briefGroupe)) {
            $this->briefGroupes->removeElement($briefGroupe);
            // set the owning side to null (unless already changed)
            if ($briefGroupe->getGroupe() === $this) {
                $briefGroupe->setGroupe(null);
            }
        }

        return $this;
    }

}
