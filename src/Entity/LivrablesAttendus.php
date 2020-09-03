<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrablesAttendusRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=LivrablesAttendusRepository::class)
 * @ApiResource()
 */
class LivrablesAttendus
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
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Briefs::class, inversedBy="livrablesAttenduses")
     */
    private $briefs;

    /**
     * @ORM\OneToMany(targetEntity=LivrablesAttenduApprenant::class, mappedBy="LivrableAttendu")
     */
    private $livrablesAttenduApprenants;

    public function __construct()
    {
        $this->briefs = new ArrayCollection();
        $this->livrablesAttenduApprenants = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
        }

        return $this;
    }

    public function removeBrief(Briefs $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
        }

        return $this;
    }

    /**
     * @return Collection|LivrablesAttenduApprenant[]
     */
    public function getLivrablesAttenduApprenants(): Collection
    {
        return $this->livrablesAttenduApprenants;
    }

    public function addLivrablesAttenduApprenant(LivrablesAttenduApprenant $livrablesAttenduApprenant): self
    {
        if (!$this->livrablesAttenduApprenants->contains($livrablesAttenduApprenant)) {
            $this->livrablesAttenduApprenants[] = $livrablesAttenduApprenant;
            $livrablesAttenduApprenant->setLivrableAttendu($this);
        }

        return $this;
    }

    public function removeLivrablesAttenduApprenant(LivrablesAttenduApprenant $livrablesAttenduApprenant): self
    {
        if ($this->livrablesAttenduApprenants->contains($livrablesAttenduApprenant)) {
            $this->livrablesAttenduApprenants->removeElement($livrablesAttenduApprenant);
            // set the owning side to null (unless already changed)
            if ($livrablesAttenduApprenant->getLivrableAttendu() === $this) {
                $livrablesAttenduApprenant->setLivrableAttendu(null);
            }
        }

        return $this;
    }
}
