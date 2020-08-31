<?php

namespace App\Controller;

use App\Entity\Referenciel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class ReferencielController extends AbstractController
{
    /**
     * @Route(
     * name="referentiels_write",
     * path="api/admin/referentiels",
     * methods={"POST"},
     * defaults={
     * "_controller"="\App\Controller\ReferencielController::postReferentiels",
     * "_api_resource_class"=Referenciel::class,
     * "_api_collection_operation_name"="post_referentiels"
     * }
     * )
     */
    public function postReferentiels(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager)
    {

        $referentielTab = json_decode($request->getContent(),true);
        $tagsTab = $referentielTab['tags'];
        foreach ($tagsTab as $tag) {
            $tags[] = $serializer->denormalize($tag,"App\Entity\Tag");
        }
        unset($referentielTab["tags"]);
        $groupeTag = $serializer->denormalize($referentielTab,"App\Entity\GroupeTag");

        foreach ($tags as $tag) {
            $groupeTag->addTag($tag);
            $manager->persist($tag);
        }
        $manager->persist($groupeTag);

        $manager->flush();

        return new Response("succes");
    }


    public function __construct(EntityManagerInterface $em)
    {
        $this->em =$em;
    }
    public function __invoke(Referenciel $data)
    {
        $referentiel = $data;
        $referentiel->setIsDeleted(true);
        $this->em->flush();
        return new Response("Referenciel archive");
    }

}
