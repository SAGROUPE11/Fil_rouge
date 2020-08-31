<?php

namespace App\Entity;

use App\Entity\Promo;
use App\Entity\Briefs;
use App\Entity\LivrablePartiel;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BriefMaPromoRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BriefMaPromoRepository::class)
 */
class BriefMaPromo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"brief_Groupe:read"})
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="briefMaPromos")
     */
    private $Promo;

    /**
     * @ORM\ManyToOne(targetEntity=Briefs::class, inversedBy="briefMaPromos")
     */
    private $briefs;

    /**
     * @ORM\OneToMany(targetEntity=LivrablePartiel::class, mappedBy="briefPromo")
     */
    private $livrablePartiels;

    public function __construct()
    {
        $this->brief = new ArrayCollection();
        $this->livrablePartiels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function getPromo(): ?Promo
    {
        return $this->Promo;
    }

    public function setPromo(?Promo $Promo): self
    {
        $this->Promo = $Promo;

        return $this;
    }

    public function getBriefs(): ?Briefs
    {
        return $this->briefs;
    }

    public function setBriefs(?Briefs $briefs): self
    {
        $this->briefs = $briefs;

        return $this;
    }

    /**
     * @return Collection|LivrablePartiel[]
     */
    public function getLivrablePartiels(): Collection
    {
        return $this->livrablePartiels;
    }

    public function addLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if (!$this->livrablePartiels->contains($livrablePartiel)) {
            $this->livrablePartiels[] = $livrablePartiel;
            $livrablePartiel->setBriefPromo($this);
        }

        return $this;
    }

    public function removeLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if ($this->livrablePartiels->contains($livrablePartiel)) {
            $this->livrablePartiels->removeElement($livrablePartiel);
            // set the owning side to null (unless already changed)
            if ($livrablePartiel->getBriefPromo() === $this) {
                $livrablePartiel->setBriefPromo(null);
            }
        }

        return $this;
    }
}
