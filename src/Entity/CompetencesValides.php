<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompetencesValidesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CompetencesValidesRepository::class)
 * @ApiResource(
 *  )
 */
class CompetencesValides
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"apprenant_competence:read","commentencesvalides:read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Referenciel::class, inversedBy="competencesValides",cascade={"persist"})
     */
    private $referenciel;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="competencesValides",cascade={"persist"})
     */
    private $promo;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="competencesValides",cascade={"persist"})
     * @Groups({"competences:read"})
     */
    private $apprenant;

    /**
     * @ORM\ManyToOne(targetEntity=Competences::class, inversedBy="competencesValides",cascade={"persist"})
     * @Groups({"commentencesvalides:read","competences:read"})
     */
    private $competences;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"apprenant_competence:read","commentencesvalides:read","competences:read"})
     */
    private $niveau1;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"apprenant_competence:read","commentencesvalides:read","competences:read"})
     */
    private $niveau2;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"apprenant_competence:read","commentencesvalides:read","competences:read"})
     */
    private $niveau3;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getReferenciel(): ?Referenciel
    {
        return $this->referenciel;
    }

    public function setReferenciel(?Referenciel $referenciel): self
    {
        $this->referenciel = $referenciel;

        return $this;
    }

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    public function getApprenant(): ?Apprenant
    {
        return $this->apprenant;
    }

    public function setApprenant(?Apprenant $apprenant): self
    {
        $this->apprenant = $apprenant;

        return $this;
    }

    public function getCompetences(): ?Competences
    {
        return $this->competences;
    }

    public function setCompetences(?Competences $competences): self
    {
        $this->competences = $competences;

        return $this;
    }

    public function getNiveau1(): ?bool
    {
        return $this->niveau1;
    }

    public function setNiveau1(bool $niveau1): self
    {
        $this->niveau1 = $niveau1;

        return $this;
    }

    public function getNiveau2(): ?bool
    {
        return $this->niveau2;
    }

    public function setNiveau2(bool $niveau2): self
    {
        $this->niveau2 = $niveau2;

        return $this;
    }

    public function getNiveau3(): ?bool
    {
        return $this->niveau3;
    }

    public function setNiveau3(bool $niveau3): self
    {
        $this->niveau3 = $niveau3;

        return $this;
    }
}
