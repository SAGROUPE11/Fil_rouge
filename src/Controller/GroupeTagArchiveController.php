<?php


namespace App\Controller;

use App\Entity\GroupeTag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupeTagArchiveController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(GroupeTag $data)
    {
        $groupeTag = $data;
        $groupeTag->setIsDeleted(true);
        $this->em->flush();
        return new Response("groupeTag archive");
    }
}