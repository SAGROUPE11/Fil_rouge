<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrablesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=LivrablesRepository::class)
 */
class Livrables
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="date")
     */
    private $deadLine;

    /**
     * @ORM\ManyToMany(targetEntity=Briefs::class, inversedBy="livrables")
     */
    private $brief;

    /**
     * @ORM\ManyToMany(targetEntity=LivrablePartiel::class, inversedBy="livrables")
     */
    private $livrablePartiel;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="livrables")
     */
    private $apprenants;

    /**
     * @ORM\OneToMany(targetEntity=BriefLivrable::class, mappedBy="livrable")
     */
    private $briefLivrables;

    public function __construct()
    {
        $this->brief = new ArrayCollection();
        $this->livrablePartiel = new ArrayCollection();
        $this->apprenants = new ArrayCollection();
        $this->briefLivrables = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDeadLine(): ?\DateTimeInterface
    {
        return $this->deadLine;
    }

    public function setDeadLine(\DateTimeInterface $deadLine): self
    {
        $this->deadLine = $deadLine;

        return $this;
    }

    /**
     * @return Collection|Briefs[]
     */
    public function getBrief(): Collection
    {
        return $this->brief;
    }

    public function addBrief(Briefs $brief): self
    {
        if (!$this->brief->contains($brief)) {
            $this->brief[] = $brief;
        }

        return $this;
    }

    public function removeBrief(Briefs $brief): self
    {
        if ($this->brief->contains($brief)) {
            $this->brief->removeElement($brief);
        }

        return $this;
    }

    /**
     * @return Collection|LivrablePartiel[]
     */
    public function getLivrablePartiel(): Collection
    {
        return $this->livrablePartiel;
    }

    public function addLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if (!$this->livrablePartiel->contains($livrablePartiel)) {
            $this->livrablePartiel[] = $livrablePartiel;
        }

        return $this;
    }

    public function removeLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if ($this->livrablePartiel->contains($livrablePartiel)) {
            $this->livrablePartiel->removeElement($livrablePartiel);
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
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->contains($apprenant)) {
            $this->apprenants->removeElement($apprenant);
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
            $briefLivrable->setLivrable($this);
        }

        return $this;
    }

    public function removeBriefLivrable(BriefLivrable $briefLivrable): self
    {
        if ($this->briefLivrables->contains($briefLivrable)) {
            $this->briefLivrables->removeElement($briefLivrable);
            // set the owning side to null (unless already changed)
            if ($briefLivrable->getLivrable() === $this) {
                $briefLivrable->setLivrable(null);
            }
        }

        return $this;
    }
}
