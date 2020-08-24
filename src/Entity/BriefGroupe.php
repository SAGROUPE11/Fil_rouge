<?php

namespace App\Entity;

use App\Repository\BriefGroupeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BriefGroupeRepository::class)
 */
class BriefGroupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Groupe::class, inversedBy="briefGroupes")
     */
    private $groupe;

    /**
     * @ORM\ManyToOne(targetEntity=Briefs::class, inversedBy="briefGroupes")
     */
    private $brief;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;

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
