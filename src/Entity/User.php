<?php

namespace App\Entity;

use App\Entity\Formateur;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\DiscriminatorMap;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 *@ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *@ORM\InheritanceType("JOINED")
 *@ORM\DiscriminatorColumn(name="type",  type="string")
 *@ORM\DiscriminatorMap({"formateur" = "Formateur", "apprenant" = "Apprenant", "user" ="User", "cm" ="CM"})
 * @UniqueEntity(
 * fields={"email"},
 * message="L'email doit être unique"
 * )
 * @ApiResource(
 *    normalizationContext={"groups"={"user:read"}},
 *    denormalizationContext={"groups"={"user:write"}},
 *
 *    collectionOperations={
 *      "get"={"path":"/admin/users"},
 *      "post"={"path":"/admin/users"},
 * "get_apprenants"={
 * "method"="GET",
 * "path"="api/apprenants",
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="apprenant_liste",
 * },
 *  "post_apprenants"={
 * "method"="POST",
 * "path"="api/apprenants" ,
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="apprenant_write",
 * },
 *   "get_formateurs"={
 * "method"="GET",
 * "path"="api/formateurs",
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="formateur_liste",
 * },
 * "post_users"={
 *"method"="POST",
 *"path"="/users",
 *"route_name"="add_user",
 *},
 *  "get_user_By_Profil"={
 * "method"="GET",
 * "path"="api/admin/profils/{id}/users",
 * "access_control"="(is_granted('ROLE_Admin'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="user_By_Profil",
 * },
 * },
 *     itemOperations={
 *     "put","delete","patch","get",
 *     "put"={"path":"/admin/users"},
 * "get_apprenant_by_id"={
 * "method"="GET",
 * "path"="api/apprenants/{id}",
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="apprenants_by_id",
 * },
 *  "get_formateur_by_id"={
 * "method"="GET",
 * "path"="api/formateurs/{id}",
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * "route_name"="formateur_by_id",
 * },
 *     "put_apprenant_by_id"={
 * "method"="PUT",
 * "path"="/apprenants/{id}",
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 *    "put_formateur_by_id"={
 * "method"="PUT",
 * "path"="/formateurs/{id}",
 * "access_control"="(is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant'))",
 * "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 *  "post_utilisateur"={
 * "method"="GET",
 * "path"="/admin/users/{id}" ,
 * },
 * }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *  @Groups({"profil:read"})
     * @Groups({"user:read","user:write"})
     *
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:read","user:write","promo:read_All","groupe:read_All","promo:principal_read","promo:attente_read","promo_groupe_apprenant:read","promo_formateur:read"})
     * @Assert\NotBlank(message="Le email est obligatoire")
     */
    protected $email;

    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Le password est obligatoire")
     * @Groups({"user:read","user:write"})
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read","user:write","promo:read_All","groupe:read_All","promo:principal_read","promo:attente_read","promo_groupe_apprenant:read","promo_formateur:read"})
     *@Assert\NotBlank(message="Le firstName est obligatoire")
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read","user:write","promo:read_All","groupe:read_All","promo:principal_read","promo:attente_read","promo_groupe_apprenant:read","promo_formateur:read"})
     * @Assert\NotBlank(message="Le lastName est obligatoire")
     *
     */
    protected $lastName;
    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user:read","user:write"})
     * @Assert\NotBlank(message="Le Profil est obligatoire")
     */
    protected $profil;
    /**
     * @ORM\OneToMany(targetEntity=GroupeCompetences::class, mappedBy="user")
     */
    protected $groupeCompetences;
    
    
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profil->getLibelle();
        return array_unique($roles);
    }
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }
    public function getLastName(): ?string
    {
        return $this->lastName;
    }
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }
    public function getProfil(): ?Profil
    {
        return $this->profil;
    }
    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;
        return $this;
    }
    /**
     * @return Collection|GroupeCompetences[]
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }
    public function addGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->setUser($this);
        }
        return $this;
    }
    public function removeGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if ($this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences->removeElement($groupeCompetence);
            // set the owning side to null (unless already changed)
            if ($groupeCompetence->getUser() === $this) {
                $groupeCompetence->setUser(null);
            }
        }
        return $this;
    }
    
}