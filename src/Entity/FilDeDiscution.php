<?php

namespace App\Entity;

use App\Repository\FilDeDiscutionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FilDeDiscutionRepository::class)
 */
class FilDeDiscution
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
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="filDeDiscution",cascade={"persist"})
     */
    private $commentaires;

    /**
     * @ORM\OneToOne(targetEntity=ApprenantLivrablePartielle::class, inversedBy="filDeDiscution", cascade={"persist", "remove"})
     */
    private $apprenantLivrablePartielle;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
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


    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setFilDeDiscution($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getFilDeDiscution() === $this) {
                $commentaire->setFilDeDiscution(null);
            }
        }

        return $this;
    }

    public function getApprenantLivrablePartielle(): ?ApprenantLivrablePartielle
    {
        return $this->apprenantLivrablePartielle;
    }

    public function setApprenantLivrablePartielle(?ApprenantLivrablePartielle $apprenantLivrablePartielle): self
    {
        $this->apprenantLivrablePartielle = $apprenantLivrablePartielle;

        return $this;
    }
}
