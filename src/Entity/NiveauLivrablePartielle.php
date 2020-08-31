<?php

namespace App\Entity;

use App\Repository\NiveauLivrablePartielleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=NiveauLivrablePartielleRepository::class)
 */
class NiveauLivrablePartielle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=LivrablePartiel::class, inversedBy="niveauLivrablePartielle")
     */
    private $livrablePartiel;

    /**
     * @ORM\ManyToOne(targetEntity=Niveau::class, inversedBy="niveauLivrablePartielle")
     */
    private $niveau;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLivrablePartiel(): ?LivrablePartiel
    {
        return $this->livrablePartiel;
    }

    public function setLivrablePartiel(?LivrablePartiel $livrablePartiel): self
    {
        $this->livrablePartiel = $livrablePartiel;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }
}
