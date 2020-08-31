<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BriefsRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BriefsRepository::class)
 * @ApiResource(
 *      attributes={
 *            "input_formats"={"json"={"application/ld+json", "application/json"}},
 *            "output_formats"={"json"={"application/ld+json", "application/json"}}
 *      },
 *  collectionOperations={
 *     "get"={
 *         "path"="formateurs/briefs",
 *         "normalization_context"={"groups"={"brief:read"}},
 *         "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 *  }, 
 *      "get_promo_id_groupe_id_briefs"={
 *         "method"="GET",
 *         "path"="api/formateurs/promo/{id_promo}/groupe/{id_groupe}/briefs",
 *         "controller"=ShowBriefController::class,
 *         "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 *         "route_name"="show_promo_id_groupe_id_briefs"
 *  },
 *        "get_promo_id_briefs"={
 *         "method"="GET",
 *         "path"="api/formateurs/promo/{id_promo}/briefs",
 *         "controller"=ShowBriefController::class,
 *         "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 *         "route_name"="show_promo_id_briefs"
 *  },
 *      "get_FormateurBrouillonBrief"={
 *         "method"="GET",
 *         "path"="api/formateurs/{id}/briefs/brouillons",
 *         "controller"=ShowBriefController::class,
 *         "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 *          "route_name"="show_FormateurBrouillonBrief"
 *  },
 *   "get_FormateurValideBrief"={
 *         "method"="GET",
 *         "path"="api/formateurs/{id}/briefs/valide",
 *         "controller"=ShowBriefController::class,
 *         "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 *         "route_name"="show_FormateurValideBrief"
 *  },
 *  "get_promo_id_brief_id"={
 *          "method"="GET",
 *          "path"="api/formateurs/promo/{id_promo}/briefs/{id_brief}",
 *          "controller"=BriefController::class,
 *          "route_name"="show_promo_id_brief_id",
 *          "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 *          "route_name"="show_promoIdBriefId"
 *  },
 *  "get_brief_by_promo_Id_apprenant"={
 *           "method"="GET",
 *           "path"="api/apprenants/promo/{id_promo}/briefs",
 *           "controller"=BriefController::class,
 *           "access_control"="(is_granted('ROLE_Apprenant'))",
 *           "access_control_message"="Vous n'avez pas access à cette Ressource",
 *           "route_name"="show_briefByPromoIdApprenant"
 *   },  
 *  "post_formateur_brief"={
 *         "method"="POST",
 *         "path"="formateurs/briefs/{id}",
 *         "requirements"={"id"="\d+"},
 *         "controller"=Briefs::class,
 *          "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",                  
 *         "route_name"="add_formateur_brief"
 *      },
 * "post_brief"={
 *         "method"="POST",
 *         "path"="formateurs/briefs",
 *          "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",                  
 *         "controller"=Briefs::class,
 *         "route_name"="add_brief"
 *      }, 
 *  "post_groupe_apprenant"={
 *         "method"="POST",
 *         "path"="apprenants/{id_apprenant}/groupe/{id_groupe}/livrables",
 *          "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",                  
 *         "controller"=Briefs::class,
 *         "route_name"="add_groupe_apprenant"
 *      }
 * },
 *    itemOperations={
 * "EditPromoBrief"={
 *              "path" = "formateurs/promo/{id_promo}/brief/{id_brief}/assignation",
 *              "method"="PUT",
 *              "requirements"={"id_promo"="\d+", "id_brief"="\d+"},
 *              "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",    
 *              "route_name"="edit_promo_brief",      
 *          },
 *  "PutPromoBrief"={
 *              "path" = "formateurs/promo/{id_promo}/brief/{id_brief}",
 *              "method"="PUT",
 *              "requirements"={"id_promo"="\d+","id_brief"="\d+"},
 *              "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",    
 *              "route_name"="put_promo_brief",      
 *          }
 *  }
 * )
 */
class Briefs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"brief_Groupe:read"})
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="briefs")
     * @Groups({"brief:read_all","brief_Groupe:read"})
     */
    private $formateurs;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="briefs")
     *  @Groups({"brief_route7:read","brief_Groupe:read","brief:read"})
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, inversedBy="briefs")
     *  @Groups({"brief_route7:read","brief_Groupe:read","brief:read"})
     */
    private $niveau;

    /**
     * @ORM\OneToMany(targetEntity=BriefMaPromo::class, mappedBy="briefs")
     * @Groups({"brief_Groupe:read"})
     */
    private $briefMaPromos;

    /**
     * @ORM\OneToMany(targetEntity=BriefApprenant::class, mappedBy="brief")
     */
    private $briefApprenants;

    /**
     * @ORM\OneToMany(targetEntity=BriefLivrable::class, mappedBy="brief")
     */
    private $briefLivrables;

    /**
     * @ORM\OneToMany(targetEntity=BriefGroupe::class, mappedBy="brief")
     */
    private $briefGroupes;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, inversedBy="briefs")
     * @Groups({"brief_route7:read","brief_Groupe:read","brief:read"})
     */
    private $promo;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"brief_Groupe:read","brief:read"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"brief_Groupe:read","brief:read"})
     */
    private $nomBrief;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"brief_Groupe:read","brief:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"brief_Groupe:read","brief:read"})
     */
    private $contexte;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $livrableAttendus;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modalitePedagogique;

    /**
     * @ORM\Column(type="text")
     */
    private $critereEvaluation;

    /**
     * @ORM\Column(type="text")
     */
    private $modaliteEvaluation;

    /**
     * @ORM\Column(type="blob")
     */
    private $imagePromo;

    /**
     * @ORM\Column(type="date")
     *  @Groups({"brief_Groupe:read","brief:read"})
     */
    private $CreationDate;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"brief_Groupe:read","brief:read"})
     */
    private $etat;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archived;

    public function __construct()
    {
        $this->promo = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->niveau = new ArrayCollection();
        $this->apprenants = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->livrables = new ArrayCollection();
        $this->briefMaPromos = new ArrayCollection();
        $this->briefApprenants = new ArrayCollection();
        $this->briefLivrables = new ArrayCollection();
        $this->briefGroupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getFormateurs(): ?formateur
    {
        return $this->formateurs;
    }

    public function setFormateurs(?formateur $formateurs): self
    {
        $this->formateurs = $formateurs;

        return $this;
    }

    /**
     * @return Collection|tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    /**
     * @return Collection|niveau[]
     */
    public function getNiveau(): Collection
    {
        return $this->niveau;
    }

    public function addNiveau(niveau $niveau): self
    {
        if (!$this->niveau->contains($niveau)) {
            $this->niveau[] = $niveau;
        }

        return $this;
    }

    public function removeNiveau(niveau $niveau): self
    {
        if ($this->niveau->contains($niveau)) {
            $this->niveau->removeElement($niveau);
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
            $briefMaPromo->setBriefs($this);
        }

        return $this;
    }

    public function removeBriefMaPromo(BriefMaPromo $briefMaPromo): self
    {
        if ($this->briefMaPromos->contains($briefMaPromo)) {
            $this->briefMaPromos->removeElement($briefMaPromo);
            // set the owning side to null (unless already changed)
            if ($briefMaPromo->getBriefs() === $this) {
                $briefMaPromo->setBriefs(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BriefApprenant[]
     */
    public function getBriefApprenants(): Collection
    {
        return $this->briefApprenants;
    }

    public function addBriefApprenant(BriefApprenant $briefApprenant): self
    {
        if (!$this->briefApprenants->contains($briefApprenant)) {
            $this->briefApprenants[] = $briefApprenant;
            $briefApprenant->setBrief($this);
        }

        return $this;
    }

    public function removeBriefApprenant(BriefApprenant $briefApprenant): self
    {
        if ($this->briefApprenants->contains($briefApprenant)) {
            $this->briefApprenants->removeElement($briefApprenant);
            // set the owning side to null (unless already changed)
            if ($briefApprenant->getBrief() === $this) {
                $briefApprenant->setBrief(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BriefLivrable[]
     */
    public function getBriefLivrables(): Collection
    {
        return $this->briefLivrables;
    }

    public function addBriefLivrable(BriefLivrable $briefLivrable): self
    {
        if (!$this->briefLivrables->contains($briefLivrable)) {
            $this->briefLivrables[] = $briefLivrable;
            $briefLivrable->setBrief($this);
        }

        return $this;
    }

    public function removeBriefLivrable(BriefLivrable $briefLivrable): self
    {
        if ($this->briefLivrables->contains($briefLivrable)) {
            $this->briefLivrables->removeElement($briefLivrable);
            // set the owning side to null (unless already changed)
            if ($briefLivrable->getBrief() === $this) {
                $briefLivrable->setBrief(null);
            }
        }

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
            $briefGroupe->setBrief($this);
        }

        return $this;
    }

    public function removeBriefGroupe(BriefGroupe $briefGroupe): self
    {
        if ($this->briefGroupes->contains($briefGroupe)) {
            $this->briefGroupes->removeElement($briefGroupe);
            // set the owning side to null (unless already changed)
            if ($briefGroupe->getBrief() === $this) {
                $briefGroupe->setBrief(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromo(): Collection
    {
        return $this->promo;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promo->contains($promo)) {
            $this->promo[] = $promo;
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promo->contains($promo)) {
            $this->promo->removeElement($promo);
        }

        return $this;
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

    public function getNomBrief(): ?string
    {
        return $this->nomBrief;
    }

    public function setNomBrief(string $nomBrief): self
    {
        $this->nomBrief = $nomBrief;

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

    public function getContexte(): ?string
    {
        return $this->contexte;
    }

    public function setContexte(string $contexte): self
    {
        $this->contexte = $contexte;

        return $this;
    }

    public function getLivrableAttendus(): ?string
    {
        return $this->livrableAttendus;
    }

    public function setLivrableAttendus(string $livrableAttendus): self
    {
        $this->livrableAttendus = $livrableAttendus;

        return $this;
    }

    public function getModalitePedagogique(): ?string
    {
        return $this->modalitePedagogique;
    }

    public function setModalitePedagogique(string $modalitePedagogique): self
    {
        $this->modalitePedagogique = $modalitePedagogique;

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

    public function getModaliteEvaluation(): ?string
    {
        return $this->modaliteEvaluation;
    }

    public function setModaliteEvaluation(string $modaliteEvaluation): self
    {
        $this->modaliteEvaluation = $modaliteEvaluation;

        return $this;
    }

    public function getImagePromo()
    {
        return $this->imagePromo;
    }

    public function setImagePromo($imagePromo): self
    {
        $this->imagePromo = $imagePromo;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->CreationDate;
    }

    public function setCreationDate(\DateTimeInterface $CreationDate): self
    {
        $this->CreationDate = $CreationDate;

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

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }
}
