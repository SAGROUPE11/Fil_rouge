<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ApprenantLivrablePartielleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ApprenantLivrablePartielleRepository::class)
 * @ApiResource(
 *     itemOperations={
 *         "add_etat_apprenants"={
 *         "method"="PUT",
 *         "path"="/api/apprenants/{id_app}/livrablepartiels/{id_livrable}",
 *         "controller"=ApprenantLivrablePartielleController::class,
 *         "access_control"="(is_granted('ROLE_APPRENANT') or is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 *         "route_name"="put_etat_apprenants"
 *     },
 *     }
 * )
 */
class ApprenantLivrablePartielle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="apprenantLivrablePartielle",cascade={"persist"})
     * @Groups({"competences:read"})
     */
    private $apprenant;

    /**
     * @ORM\ManyToOne(targetEntity=LivrablePartiel::class, inversedBy="apprenantLivrablePartielle",cascade={"persist"})
     */
    private $livrablePartiel;

    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $delai;

    /**
     * @ORM\OneToOne(targetEntity=FilDeDiscution::class, mappedBy="apprenantLivrablePartielle", cascade={"persist", "remove"})
     */
    private $filDeDiscution;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLivrablePartiel(): ?LivrablePartiel
    {
        return $this->livrablePartiel;
    }

    public function setLivrablePartiel(?LivrablePartiel $livrablePartiel): self
    {
        $this->livrablePartiel = $livrablePartiel;

        return $this;
    }

    public function getDelai(): ?\DateTimeInterface
    {
        return $this->delai;
    }

    public function setDelai(\DateTimeInterface $delai): self
    {
        $this->delai = $delai;

        return $this;
    }

    public function getFilDeDiscution(): ?FilDeDiscution
    {
        return $this->filDeDiscution;
    }

    public function setFilDeDiscution(?FilDeDiscution $filDeDiscution): self
    {
        $this->filDeDiscution = $filDeDiscution;

        // set (or unset) the owning side of the relation if necessary
        $newApprenantLivrablePartielle = null === $filDeDiscution ? null : $this;
        if ($filDeDiscution->getApprenantLivrablePartielle() !== $newApprenantLivrablePartielle) {
            $filDeDiscution->setApprenantLivrablePartielle($newApprenantLivrablePartielle);
        }

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
