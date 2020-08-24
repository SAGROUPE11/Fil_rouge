<?php

namespace App\Controller;

use\App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class CMController extends AbstractController
{
    /**
     * @Route(
     * name="apprenant_liste",
     * path="api/apprenants",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\ApprenantController::showCM",
     * "_api_resource_class"=User::class,
     * "_api_collection_operation_name"="get_apprenants"
     * }
     * )
     */
    public function showCM(UserRepository $repo)
    {
        $apprenants= $repo->findByProfil("Apprenant");
        return $this->json($apprenants,Response::HTTP_OK);
    }
    /**
     * @Route(
     * name="apprenant_write",
     * path="api/apprenants",
     * methods={"POST"},
     * defaults={
     * "_controller"="\App\Controller\ApprenantController::showApprenant",
     * "_api_resource_class"=User::class,
     * "_api_collection_operation_name"="post_apprenants"
     * }
     * )
     */

    public function postapprenant(SerializerInterface $serializer, Request $request)
    {
        $userApprenant = $request->getContent();
        $user = $serializer->deserialize($userApprenant, User::class, 'json');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        return new JsonResponse("succes",Response::HTTP_CREATED,[],true);
    }
}
