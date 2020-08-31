<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 * @ApiResource(
 * normalizationContext={"groups"={"promo:read_All","promo:read"}},
 * collectionOperations=
 * {
*   "addPromo" = {
 *             "method"= "POST",
 *            "path" = "/admin/promos",
 *           "route_name" = "addPromo"
 *       },
 * "get_promo"={
 * "methods"="GET",
 * "path"="/admin/promo",
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="promo_liste",
 * },
 * "get_promotion"={
 * "methods"="GET",
 * "path"="/admin/promo/principal",
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="promo_list"
 *          },
 * "add_promo" = {
 *              "method"="POST",
 *              "path"="/admin/promos",
 *              "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *           },
 * "get_Liste_attentes"={
 * "methods"="GET",
 * "path"="/admin/promo/apprenants/attentes",
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="liste_attentes",
 *          }
 *      },
 *       itemOperations={
 *     "put","delete","patch","get",
 *    "get_promo_by_id"={
 *    "method"="GET",
 *    "path"="api/admin/promo/{id}",
 *    "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource",
 *    "route_name"="show_promo_by_id"
 *          },
 *     "getPromoPrincipalById"={
 *    "method"="GET",
 *    "path"="api/admin/promo/{id}/principal",
 *    "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource",
 *    "route_name"="showPromoPrincipalById"
 *          },
 *  "getPromoRefentielById"={
 *    "method"="GET",
 *    "path"="api/admin/promo/{id}/referentiels",
 *    "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource",
 *    "route_name"="showPromoRefentielById"
 *          },
 *   "getApprenantAttenteById"={
 *    "method"="GET",
 *    "path"="api/admin/promo/{id}/apprenants/attente",
 *    "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource",
 *    "route_name"="showApprenantAttenteById",
 *          },
 * "getGroupeApprenantById"={
 *    "method"="GET",
 *    "path"="api/admin/promo/{id1}/groupes/{id2}/apprenants",
 *    "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource",
 *    "route_name"="showGroupeApprenantById",
 *          },
 * "getFormateurById"={
 *    "method"="GET",
 *    "path"="api/admin/promo/{id}/formateurs",
 *    "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource",
 *    "route_name"="showFormateurById",
 *          }
 * }
 * )
 */
class Promo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"groupe:read_All","brief_Groupe:read","promo:read_CRGrp_C","promo_groupe_apprenant:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read_All","brief_Groupe:read","promo:write","promo:read_CRGrp_C","promo_groupe_apprenant:read"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read_All","brief_Groupe:read","promo:write","promo:read_CRGrp_C","promo_groupe_apprenant:read"})
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read_All","brief_Groupe:read","promo:write","promo:read_CRGrp_C","promo_groupe_apprenant:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read_All","brief_Groupe:read","promo:write","promo:read_CRGrp_C","promo_groupe_apprenant:read"})
     */
    private $lieu;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read_All","brief_Groupe:read","promo:write","promo:read_CRGrp_C","promo_groupe_apprenant:read"})
     */
    private $reference;

    /**
     * @ORM\Column(type="date")
     * @Groups({"groupe:read_All","brief_Groupe:read","promo:write","promo:read_CRGrp_C","promo_groupe_apprenant:read"})
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     * @Groups({"groupe:read_All","brief_Groupe:read","promo:write","promo:read_CRGrp_C","promo_groupe_apprenant:read"})
     */
    private $dateFinProvisoire;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read_All","brief_Groupe:read","promo:write","promo:read_CRGrp_C","promo_groupe_apprenant:read"})
     */
    private $fabrique;

    /**
     * @ORM\Column(type="date")
     * @Groups({"groupe:read_All","brief_Groupe:read","promo:write","promo:read_CRGrp_C","promo_groupe_apprenant:read"})
     */
    private $dateFinReelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read_All","brief_Groupe:read","promo:write","promo:read_CRGrp_C","promo_groupe_apprenant:read"})
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promo", cascade={"persist"})
     * @Groups({"promo:read_All","promo:principal_read","promo:write","promo:read","promo_groupe_apprenant:read","promo_formateur:read"})
     */
    private $groupe;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="promos",cascade={"persist"})
     * @Groups({"promo:read_All","promo:principal_read","promo:read","promo_formateur:read"})
     */
    private $formateur;

    /**
     * @ORM\ManyToMany(targetEntity=Referenciel::class, inversedBy="promos",cascade={"persist"})
     * @Groups({"promo:read_All","groupe:read_All","promo:principal_read","promo:attente_read","promo:read","promo:read_CRGrp_C","promo_groupe_apprenant:read","promo_formateur:read"})
     */
    private $referenciel;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="promo",cascade={"persist"})
     * @Groups({"groupe:read_All","promo:principal_read","promo:attente_read"})
     */
    private $apprenant;

    /**
     * @ORM\OneToMany(targetEntity=BriefMaPromo::class, mappedBy="Promo",cascade={"persist"})
     * @Groups({"brief_Groupe:read"})
     */
    private $briefMaPromos;

    /**
     * @ORM\ManyToMany(targetEntity=Briefs::class, mappedBy="promo",cascade={"persist"})
     */
    private $briefs;

    /**
     * @ORM\OneToMany(targetEntity=CompetencesValides::class, mappedBy="promo",cascade={"persist"})
     */
    private $competencesValides;



    public function __construct()
    {
        $this->groupe = new ArrayCollection();
        $this->formateur = new ArrayCollection();
        $this->referenciel = new ArrayCollection();
        $this->apprenant = new ArrayCollection();
        $this->briefMaPromos = new ArrayCollection();
        $this->briefs = new ArrayCollection();
        $this->competencesValides = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFinProvisoire(): ?\DateTimeInterface
    {
        return $this->dateFinProvisoire;
    }

    public function setDateFinProvisoire(\DateTimeInterface $dateFinProvisoire): self
    {
        $this->dateFinProvisoire = $dateFinProvisoire;

        return $this;
    }

    public function getFabrique(): ?string
    {
        return $this->fabrique;
    }

    public function setFabrique(string $fabrique): self
    {
        $this->fabrique = $fabrique;

        return $this;
    }

    public function getDateFinReelle(): ?\DateTimeInterface
    {
        return $this->dateFinReelle;
    }

    public function setDateFinReelle(\DateTimeInterface $dateFinReelle): self
    {
        $this->dateFinReelle = $dateFinReelle;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupe(): Collection
    {
        return $this->groupe;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupe->contains($groupe)) {
            $this->groupe[] = $groupe;
            $groupe->setPromo($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupe->contains($groupe)) {
            $this->groupe->removeElement($groupe);
            // set the owning side to null (unless already changed)
            if ($groupe->getPromo() === $this) {
                $groupe->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateur(): Collection
    {
        return $this->formateur;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateur->contains($formateur)) {
            $this->formateur[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        if ($this->formateur->contains($formateur)) {
            $this->formateur->removeElement($formateur);
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

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenant(): Collection
    {
        return $this->apprenant;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenant->contains($apprenant)) {
            $this->apprenant[] = $apprenant;
            $apprenant->setPromo($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenant->contains($apprenant)) {
            $this->apprenant->removeElement($apprenant);
            // set the owning side to null (unless already changed)
            if ($apprenant->getPromo() === $this) {
                $apprenant->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BriefMaPromo[]
     */
    public function getBriefMaPromos(): Collection
    {
        return $this->briefMaPromos;
    }

    public function addBriefMaPromo(BriefMaPromo $briefMaPromo): self
    {
        if (!$this->briefMaPromos->contains($briefMaPromo)) {
            $this->briefMaPromos[] = $briefMaPromo;
            $briefMaPromo->setPromo($this);
        }

        return $this;
    }

    public function removeBriefMaPromo(BriefMaPromo $briefMaPromo): self
    {
        if ($this->briefMaPromos->contains($briefMaPromo)) {
            $this->briefMaPromos->removeElement($briefMaPromo);
            // set the owning side to null (unless already changed)
            if ($briefMaPromo->getPromo() === $this) {
                $briefMaPromo->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Briefs[]
     */
    public function getBriefs(): Collection
    {
        return $this->briefs;
    }

    public function addBrief(Briefs $brief): self
    {
        if (!$this->briefs->contains($brief)) {
            $this->briefs[] = $brief;
            $brief->addPromo($this);
        }

        return $this;
    }

    public function removeBrief(Briefs $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
            $brief->removePromo($this);
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
            $competencesValide->setPromo($this);
        }

        return $this;
    }

    public function removeCompetencesValide(CompetencesValides $competencesValide): self
    {
        if ($this->competencesValides->contains($competencesValide)) {
            $this->competencesValides->removeElement($competencesValide);
            // set the owning side to null (unless already changed)
            if ($competencesValide->getPromo() === $this) {
                $competencesValide->setPromo(null);
            }
        }

        return $this;
    }


}
