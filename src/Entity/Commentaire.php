<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"commentaire:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"commentaire:read"})
     */
    private $description;


    /**
     * @ORM\ManyToOne(targetEntity=FilDeDiscution::class, inversedBy="commentaires")
     */
    private $filDeDiscution;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="commentaires")
     */
    private $formateur;

    /**
     * @ORM\Column(type="date")
     *  @Groups({"commentaire:read"})
     */
    private $dateCreation;


    public function getId(): ?int
    {
        return $this->id;
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


    public function getFilDeDiscution(): ?FilDeDiscution
    {
        return $this->filDeDiscution;
    }

    public function setFilDeDiscution(?FilDeDiscution $filDeDiscution): self
    {
        $this->filDeDiscution = $filDeDiscution;

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

}
