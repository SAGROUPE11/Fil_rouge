<?php

namespace App\Entity;

use App\Repository\BriefApprenantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BriefApprenantRepository::class)
 */
class BriefApprenant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Briefs::class, inversedBy="briefApprenants")
     */
    private $brief;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="briefApprenants")
     */
    private $apprenant;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getApprenant(): ?Apprenant
    {
        return $this->apprenant;
    }

    public function setApprenant(?Apprenant $apprenant): self
    {
        $this->apprenant = $apprenant;

        return $this;
    }
}
