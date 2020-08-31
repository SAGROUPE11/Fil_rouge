<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrablePartielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LivrablePartielRepository::class)
 * @ApiResource(
 * collectionOperations={
 *        "get_commentaire_formateur"={
 *         "method"="GET",
 *         "path"="/api/formateurs/livrablepartiels/{id_livr}/commentaires",
 *         "controller"=LivrablePartielController::class,
 *         "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_Admin'))",
 *         "route_name"="show_commentaire_formateur"
 *     },
 *      "get_statistiques_competences"={
 *         "method"="GET",
 *         "path"="/api/formateurs/promo/{id_promo}/referentiel/{id_ref}/competences",
 *         "controller"=CompetencesValidesController::class,
 *         "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_FORMATEUR'))",
 *         "route_name"="show_statistiques_competences"
 *     },
 *       "get_statistiques_competencesvalid"={
 *         "method"="GET",
 *         "path"="/api/formateurs/promo/{id_promo}/referentiel/{id_ref}/statistiques/competences",
 *         "controller"=CompetencesValidesController::class,
 *         "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_FORMATEUR'))",
 *         "route_name"="show_statistiques_competencesvalid"
 *     },
 *    "add_commentaire_formateur"={
 *         "method"="POST",
 *         "path"="/api/formateurs/livrablepartiels/{id_liv}/commentaires",
 *         "controller"=LivrablePartielController::class,
 *         "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_Admin'))",
 *         "route_name"="post_commentaire_formateur"
 *     },
 *      "get_competences_apprenant_id"={
 *         "method"="GET",
 *         "path"="/api/apprenant/{id_apprenant}/promo/{id_promo}/referentiel/{id_ref}/competences",
 *         "controller"=LivrablePartielController::class,
 *         "access_control"="(is_granted('ROLE_APPRENANT') or is_granted('ROLE_Admin'))",
 *         "route_name"="show_competences_apprenant_id"
 *     },
 *     "get_statistiques_apprenant_id"={
 *         "method"="GET",
 *         "path"="/api/apprenants/{id_app}/promo/{id_promo}/referentiel/{id_ref}/statistiques/briefs",
 *         "controller"=LivrablePartielController::class,
 *         "access_control"="(is_granted('ROLE_APPRENANT') or is_granted('ROLE_Admin'))",
 *         "route_name"="show_statistiques_apprenant_id"
 *     },
 *     "add_commentaire_apprenant"={
 *         "method"="POST",
 *         "path"="/api/apprenants/livrablepartiels/{id}/commentaires",
 *         "controller"=LivrablePartielController::class,
 *         "access_control"="(is_granted('ROLE_APPRENANT') or is_granted('ROLE_Admin'))",
 *         "route_name"="post_commentaire_apprenant"
 *     }
 *  },
 *   itemOperations={
 *     "get"={},
 *     "add_livrable_partiel_formateurs"={
 *         "method"="POST",
 *         "path"="/api/formateurs/promo/{id_promo}/brief/{id_brief}/livrablepartiels",
 *         "controller"=LivrablePartielController::class,
 *         "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_Admin'))",
 *         "route_name"="post_livrable_partiel_formateurs"
 *     },
 *       "remove_livrable_partiel"={
 *         "method"="DELETE",
 *         "path"=" /api/formateurs/promo/{id_promo}/brief/{id_brief}/livrablepartiels/{id_livrable_partiel}",
 *         "controller"=LivrablePartielController::class,
 *         "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_Admin'))",
 *         "route_name"="livrable_partiel_remove"
 *     },
 *     }
 * )
 */
class LivrablePartiel
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
     * @ORM\ManyToMany(targetEntity=Livrables::class, mappedBy="livrablePartiel",cascade={"persist"})
     */
    private $livrables;


    /**
     * @ORM\OneToMany(targetEntity=ApprenantLivrablePartielle::class, mappedBy="livrablePartiel",cascade={"persist"})
     * @Groups({"competences:read"})
     */
    private $apprenantLivrablePartielle;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreRendu;

    /**
     * @ORM\ManyToOne(targetEntity=BriefMaPromo::class, inversedBy="livrablePartiels")
     */
    private $briefPromo;

    /**
     * @ORM\OneToMany(targetEntity=NiveauLivrablePartielle::class, mappedBy="livrablePartiel")
     */
    private $niveauLivrablePartielle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archived;

    /**
     * @ORM\Column(type="datetime")
     */
    private $delai;


    public function __construct()
    {
        $this->livrables = new ArrayCollection();
        $this->apprenants = new ArrayCollection();
        $this->apprenantLivrablePartielle = new ArrayCollection();
        $this->niveau = new ArrayCollection();
        $this->niveauLivrablePartielle = new ArrayCollection();
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
     * @return Collection|Livrables[]
     */
    public function getLivrables(): Collection
    {
        return $this->livrables;
    }

    public function addLivrable(Livrables $livrable): self
    {
        if (!$this->livrables->contains($livrable)) {
            $this->livrables[] = $livrable;
            $livrable->addLivrablePartiel($this);
        }

        return $this;
    }

    public function removeLivrable(Livrables $livrable): self
    {
        if ($this->livrables->contains($livrable)) {
            $this->livrables->removeElement($livrable);
            $livrable->removeLivrablePartiel($this);
        }

        return $this;
    }


    /**
     * @return Collection|ApprenantLivrablePartielle[]
     */
    public function getApprenantLivrablePartielle(): Collection
    {
        return $this->apprenantLivrablePartielle;
    }

    public function addApprenantLivrablePartielle(ApprenantLivrablePartielle $apprenantLivrablePartielle): self
    {
        if (!$this->apprenantLivrablePartielle->contains($apprenantLivrablePartielle)) {
            $this->apprenantLivrablePartielle[] = $apprenantLivrablePartielle;
            $apprenantLivrablePartielle->setLivrablePartiel($this);
        }

        return $this;
    }

    public function removeApprenantLivrablePartielle(ApprenantLivrablePartielle $apprenantLivrablePartielle): self
    {
        if ($this->apprenantLivrablePartielle->contains($apprenantLivrablePartielle)) {
            $this->apprenantLivrablePartielle->removeElement($apprenantLivrablePartielle);
            // set the owning side to null (unless already changed)
            if ($apprenantLivrablePartielle->getLivrablePartiel() === $this) {
                $apprenantLivrablePartielle->setLivrablePartiel(null);
            }
        }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNombreRendu(): ?int
    {
        return $this->nombreRendu;
    }

    public function setNombreRendu(int $nombreRendu): self
    {
        $this->nombreRendu = $nombreRendu;

        return $this;
    }

    public function getBriefPromo(): ?BriefMaPromo
    {
        return $this->briefPromo;
    }

    public function setBriefPromo(?BriefMaPromo $briefPromo): self
    {
        $this->briefPromo = $briefPromo;

        return $this;
    }

    /**
     * @return Collection|NiveauLivrablePartielle[]
     */
    public function getNiveauLivrablePartielle(): Collection
    {
        return $this->niveauLivrablePartielle;
    }

    public function addNiveauLivrablePartielle(NiveauLivrablePartielle $niveauLivrablePartielle): self
    {
        if (!$this->niveauLivrablePartielle->contains($niveauLivrablePartielle)) {
            $this->niveauLivrablePartielle[] = $niveauLivrablePartielle;
            $niveauLivrablePartielle->setLivrablePartiel($this);
        }

        return $this;
    }

    public function removeNiveauLivrablePartielle(NiveauLivrablePartielle $niveauLivrablePartielle): self
    {
        if ($this->niveauLivrablePartielle->contains($niveauLivrablePartielle)) {
            $this->niveauLivrablePartielle->removeElement($niveauLivrablePartielle);
            // set the owning side to null (unless already changed)
            if ($niveauLivrablePartielle->getLivrablePartiel() === $this) {
                $niveauLivrablePartielle->setLivrablePartiel(null);
            }
        }

        return $this;
    }

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

}
