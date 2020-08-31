<?php

namespace App\Entity;

use App\Entity\Briefs;
use App\Entity\Groupe;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BriefGroupeRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BriefGroupeRepository::class)
 */
class BriefGroupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"brief_Groupe:read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Groupe::class, inversedBy="briefGroupes")
     * @Groups({"brief_Groupe:read"})
     */
    private $groupe;

    /**
     * @ORM\ManyToOne(targetEntity=Briefs::class, inversedBy="briefGroupes")
     * @Groups({"brief_Groupe:read"})
     */
    private $brief;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief_Groupe:read"})
     */
    private $statut;

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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
