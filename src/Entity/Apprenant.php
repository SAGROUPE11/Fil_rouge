<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ApprenantRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 * @ApiResource(
 * collectionOperations={
 * "post_avatar"={
 *"method"="POST",
 *"path"="/apprenants",
 *"route_name"="add_apprenant",
 *},
 *}
 *)
 */
class Apprenant extends User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"groupe:read_All","promo:principal_read","promo:attente_read","promo_groupe_apprenant:read","apprenant_competence:read"})
     * @Groups({"commentencesvalides:read","competences:read"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read_All","promo:principal_read","promo:attente_read","promo_groupe_apprenant:read", "apprenant_competence:read"})
     *  @Groups({"commentencesvalides:read","competences:read"})
     */
    private $adresse;

    /**
     * @ORM\ManyToMany(targetEntity=ProfilSorties::class, inversedBy="apprenants")
     */
    private $profilSorties;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read_All","promo:principal_read","promo:attente_read","promo_groupe_apprenant:read", "apprenant_competence:read","competences:read"})
     *
     */
    private $statut;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, inversedBy="apprenants", cascade={"persist"})
     */
    private $groupe;

    /**
     * @ORM\Column(type="blob")
     */
    private $avatar;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="apprenant")
     */
    private $promo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $en_attente=true;

    /**
     * @ORM\OneToMany(targetEntity=BriefApprenant::class, mappedBy="apprenant")
     */
    private $briefApprenants;

    /**
     * @ORM\OneToMany(targetEntity=CompetencesValides::class, mappedBy="apprenant")
     * @Groups({"apprenant_competence:read","competences:read"})
     */
    private $competencesValides;

    /**
     * @ORM\OneToMany(targetEntity=ApprenantLivrablePartielle::class, mappedBy="apprenant")
     */
    private $apprenantLivrablePartielle;
   
    public function __construct()
    {
        $this->profilSorties = new ArrayCollection();
        $this->groupe = new ArrayCollection();
        $this->brief = new ArrayCollection();
        $this->briefApprenants = new ArrayCollection();
        $this->competencesValides = new ArrayCollection();
        $this->apprenantLivrablePartielle = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection|ProfilSorties[]
     */
    public function getProfilSorties(): Collection
    {
        return $this->profilSorties;
    }

    public function addProfilSorty(ProfilSorties $profilSorty): self
    {
        if (!$this->profilSorties->contains($profilSorty)) {
            $this->profilSorties[] = $profilSorty;
        }

        return $this;
    }

    public function removeProfilSorty(ProfilSorties $profilSorty): self
    {
        if ($this->profilSorties->contains($profilSorty)) {
            $this->profilSorties->removeElement($profilSorty);
        }

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
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupe->contains($groupe)) {
            $this->groupe->removeElement($groupe);
        }

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

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

    public function getEnAttente(): ?bool
    {
        return $this->en_attente;
    }

    public function setEnAttente(bool $en_attente): self
    {
        $this->en_attente = $en_attente;

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
            $briefApprenant->setApprenant($this);
        }

        return $this;
    }

    public function removeBriefApprenant(BriefApprenant $briefApprenant): self
    {
        if ($this->briefApprenants->contains($briefApprenant)) {
            $this->briefApprenants->removeElement($briefApprenant);
            // set the owning side to null (unless already changed)
            if ($briefApprenant->getApprenant() === $this) {
                $briefApprenant->setApprenant(null);
            }
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
            $competencesValide->setApprenant($this);
        }

        return $this;
    }

    public function removeCompetencesValide(CompetencesValides $competencesValide): self
    {
        if ($this->competencesValides->contains($competencesValide)) {
            $this->competencesValides->removeElement($competencesValide);
            // set the owning side to null (unless already changed)
            if ($competencesValide->getApprenant() === $this) {
                $competencesValide->setApprenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ApprenantLivrablePartielle[]
     */
    public function getApprenantLivrablePartielle(): Collection
    {
        return $this->apprenantLivrablePartielle;
    }

    public function addApprenantLivrablePartielle(ApprenantLivrablePartielle $apprenantLivrablePartielle): self
    {
        if (!$this->apprenantLivrablePartielle->contains($apprenantLivrablePartielle)) {
            $this->apprenantLivrablePartielle[] = $apprenantLivrablePartielle;
            $apprenantLivrablePartielle->setApprenant($this);
        }

        return $this;
    }

    public function removeApprenantLivrablePartielle(ApprenantLivrablePartielle $apprenantLivrablePartielle): self
    {
        if ($this->apprenantLivrablePartielle->contains($apprenantLivrablePartielle)) {
            $this->apprenantLivrablePartielle->removeElement($apprenantLivrablePartielle);
            // set the owning side to null (unless already changed)
            if ($apprenantLivrablePartielle->getApprenant() === $this) {
                $apprenantLivrablePartielle->setApprenant(null);
            }
        }

        return $this;
    }

  


   
}
