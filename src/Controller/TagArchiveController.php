<?php

namespace App\Controller;

use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagArchiveController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em =$em;
    }
    public function __invoke(Tag $data)
    {
        $tag = $data;
        $tag->setIsDeleted(true);
        $this->em->flush();

        return new Response("tag archived");
    }
}