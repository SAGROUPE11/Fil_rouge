<?php

namespace App\Entity;

use App\Repository\BriefLivrableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BriefLivrableRepository::class)
 */
class BriefLivrable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Livrables::class, inversedBy="briefLivrables")
     */
    private $livrable;

    /**
     * @ORM\ManyToOne(targetEntity=Briefs::class, inversedBy="briefLivrables")
     */
    private $brief;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLivrable(): ?Livrables
    {
        return $this->livrable;
    }

    public function setLivrable(?Livrables $livrable): self
    {
        $this->livrable = $livrable;

        return $this;
    }

    public function getBrief(): ?Briefs
    {
        return $this->brief;
    }

    public function setBrief(?Briefs $brief): self
    {
        $this->brief = $brief;

        return $this;
    }
}
