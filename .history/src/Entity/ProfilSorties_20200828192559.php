<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfilSortiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfilSortiesRepository::class)
 * @ApiResource(
 * normalizationContext={"groups"={"profilsortie:read_All"}},
 * collectionOperations=
 * {
 *      "get"=
 *      {
 *          "path"="admin/profilsortie"
 *      },
 * 
 *      "get_profilsortie"=
 *      {
 *          "path"="admin/profilsortie",
 *          "deserialize"=false
 *      },
 * "post"={"path":"/admin/profilsorties"},
 * "get_profilsortie"={
 * "methods"="GET",
 * "path"="/admin/profilsorties",
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="profilsortie_liste",
 * },
 * "get"={"path":"/admin/profilsorties/apprenant"},
 * "get_profilsortie"={
 * "methods"="GET",
 * "path"="/admin/profilsorties/apprenants",
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="profilsortie_liste",
 * },
 * "post_profilsortie"={
 * "methods"="POST",
 * "path"="/admin/profilsorties",
 * "access_control"="(is_granted('ROLE_Admin'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="new_profilsortie",
 * },
 * },
 * 
 *  itemOperations={
 * "get_profilsorties_by_id"={
 * "method"="GET",
 * "path"="/admin/profilsorties/{id}" ,
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 *   "delete_profilsorties_by_id"={
 *  "method"="DELETE",
 *  "path"="/admin/profilsorties/{id}",
 * "access_control"="(is_granted('ROLE_Admin'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 *},
 *  "get_profilsorties_by_id"={
 * "method"="GET",
 * "path"="/admin/profilsorties/{id}/apprenants" ,
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 * "put_profilsorties_by_id"={
 * "method"="PUT",
 * "path"="/admin/profilsorties/{id}/apprenants" ,
 * "access_control"="(is_granted('ROLE_Admin'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 * }
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
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, mappedBy="profilSorties")
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
