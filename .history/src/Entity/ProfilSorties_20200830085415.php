<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilSortiesRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProfilSortiesRepository::class)
 * @ApiResource(
 *  normalizationContext={"groups"={"groupe:read_all"}},
 * collectionOperations=
 * {
 *  "get",
 * 
 *   "get_profilsorties"=
 *  {
 *      "normatization_context"={"groupe:red_profilsortie"},
 *      "method"="GET",
 *      "path"="api/admin/profilsorties" ,
 *      "route_name"="getprofilsorties",
 *      "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
*  "add_ProfilSortie"=
 *  {
 *      "normatization_context"={"groupe:ApprenantPromoByProfilSortie"},
 *      "method"="POST",
 *      "path"="api/admin/profilsorties" ,
 *      "route_name"="addProfilSortie",
 *   },
 * },
 * 
 * 
 *  itemOperations=
 *  {
 *      "get_ApprenantProfilSortie"=
 *      {
 *          "normatization_context"={"groupe:red_profilsortie"},
 *          "method"="GET",
 *          "path"="/admin/profilsorties/{id}",
 *          "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      },
 * 
 *      "edite_ProfilSortie"=
 *      {
 *          "method"="PUT",
 *          "path"="admin/profilsortie/{id}",
 *          "deserialize"=false,
 *          "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      },
 
 * 
 *   },
 *      
 * )
 */
class ProfilSorties
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read_all","groupe:red_profilsortie","groupe:ApprenantPromoByProfilSortie","groupe:ApprenantPromoByProfilSortieById"})
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, mappedBy="profilSorties")
     * @Groups({"groupe:read_all","groupe:ApprenantPromoByProfilSortie","groupe:ApprenantPromoByProfilSortieById"})
     * 
     */
    private $apprenants;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
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
            $apprenant->addProfilSorty($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->contains($apprenant)) {
            $this->apprenants->removeElement($apprenant);
            $apprenant->removeProfilSorty($this);
        }

        return $this;
    }
}
