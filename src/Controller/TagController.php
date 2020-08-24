<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\GroupeTag;
use App\Repository\GroupeTagRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Json;

class TagController extends AbstractController
{

    /**
     * @Route(
     * path="api/admin/groupetag",
     * name="groupetag",
     * methods={"POST"},
     * defaults={
     * "_api_resource_class"=GroupeTag::class,
     * "_api_collection_operation_name"="groupeTag"
     * }
     * )
     */
    public function AddgroupeTag(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager)
    {

        $groupeTagTab = json_decode($request->getContent(),true);
        $tagsTab = $groupeTagTab['tags'];
        foreach ($tagsTab as $tag) {
            $tags[] = ($serializer->denormalize($tag,"App\Entity\Tag"))->setIsDeleted(false);
        }
        unset($groupeTagTab["tags"]);
        $groupeTag = ($serializer->denormalize($groupeTagTab,"App\Entity\GroupeTag"))->setIsDeleted(false);

        foreach ($tags as $tag) {
            $groupeTag->addTag($tag);
            $manager->persist($tag);
        }
        $manager->persist($groupeTag);

        $manager->flush();

        return new Response("succes");
    }

}