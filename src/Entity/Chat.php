<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ChatRepository;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 * @ApiResource(
 *     attributes={
 *          "pagination_items_per_page"=20,
 *     },
 *     collectionOperations={
 *              "addChat"=
 *              {
 *                  "method"="POST",
 *                   "path"="/users/promo/{id}/apprenant/{id_a}/chats",
 *                   "route_name"="add_chat",
 *              },
 * 
 *               "getChat"=
 *              {
 *                  "method"="GET",
 *                   "path"="/users/promo/{id}/apprenant/{id_a}/chats",
 *                   "route_name"="get_chat",
 *              },
 *            
 *              
 *     },
 *     itemOperations={
 *          "get",
 *    }
 * )
 */
class Chat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"show"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"show"})
     */
    protected $message;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $pieceJointes;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="chats")
     * @Groups({"show"})
     */
    private $user;

    // /**
    //  * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="chats")
    //  * @Groups({"show"})
    //  */
    // private $promo;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"show"})
     */
    private $creatAt;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="chats")
     */
    private $promo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getPieceJointes()
    {
        return stream_get_contents($this->pieceJointes);
    }

    public function setPieceJointes($pieceJointes): self
    {
        $this->pieceJointes = $pieceJointes;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }


    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    // public function getPromo(): ?Promo
    // {
    //     return $this->promo;
    // }

    // public function setPromo(?Promo $promo): self
    // {
    //     $this->promo = $promo;

    //     return $this;
    // }
 
    public function getCreatAt(): ?\DateTimeInterface
    {
        return $this->creatAt;
    }

    public function setCreatAt(\DateTimeInterface $creatAt): self
    {
        $this->creatAt = $creatAt;

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
}