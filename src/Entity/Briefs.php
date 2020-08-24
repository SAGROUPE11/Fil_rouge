<?php

namespace App\Entity;

use App\Entity\Briefs;
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
 * routePrefix="/formateurs",
 *  collectionOperations={
 *      "get_FormateurPromoGroupesBriefById"={
 *         "method"="GET",
 *         "path"="/{id_formateur}/promo/{id_promo}/briefs/{id_brief}",
 *         "requirements"={"id_formateur"="\d+","id_promo"="\d+","id_brief"="\d+"},
 *         "controller"=Briefs::class,
 *         "route_name"="show_FormateurPromoGroupesBriefById",
 *  },    
 *  "post_formateur_brief"={
 *         "method"="POST",
 *         "path"="/briefs/{id}",
 *         "requirements"={"id"="\d+"},
 *         "controller"=Briefs::class,
 *         "route_name"="add_formateur_brief",
 *  }
 *  }
 * )
 */
class Briefs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $enonce;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contexte;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEcheance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;


    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="briefs")
     * @Groups({"brief:read_all"})
     */
    private $formateurs;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="briefs")
     *  @Groups({"brief_route7:read"})
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, inversedBy="briefs")
     *  @Groups({"brief_route7:read"})
     */
    private $niveau;

    /**
     * @ORM\OneToMany(targetEntity=BriefMaPromo::class, mappedBy="briefs")
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
     * @Groups({"brief_route7:read"})
     */
    private $promo;

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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getEnonce(): ?string
    {
        return $this->enonce;
    }

    public function setEnonce(string $enonce): self
    {
        $this->enonce = $enonce;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDateEcheance(): ?\DateTimeInterface
    {
        return $this->dateEcheance;
    }

    public function setDateEcheance(\DateTimeInterface $dateEcheance): self
    {
        $this->dateEcheance = $dateEcheance;

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
}
