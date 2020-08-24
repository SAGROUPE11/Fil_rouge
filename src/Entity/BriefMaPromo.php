<?php

namespace App\Entity;

use App\Repository\BriefMaPromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BriefMaPromoRepository::class)
 */
class BriefMaPromo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
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

    public function __construct()
    {
        $this->brief = new ArrayCollection();
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
}
