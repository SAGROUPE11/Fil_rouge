<?php

namespace App\Controller;

use App\Entity\ProfilSorties;
use App\Repository\ProfilSortiesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilSortieController extends AbstractController
{
     /**
     * @Route(
     * name="profilsortie_liste",
     * path="api/admin/profilsorties/apprenants",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\ProfilSortieController::getprofilsortie",
     * "_api_resource_class"=ProfilSorties::class,
     * "_api_collection_operation_name"="get_profilsortie"
     * }
     * )
     */
    public function showProfilSortie(ProfilSortiesRepository $repo)
    {
        $ps= $repo->findByProfilSortie();
        return $this->json($ps,Response::HTTP_OK);
    }

     /**
     * @Route(
     * name="profilsortie_liste",
     * path="api/admin/profilsorties",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\ProfilSortieController::getprofilsortie",
     * "_api_resource_class"=ProfilSorties::class,
     * "_api_collection_operation_name"="get_profilsortie"
     * }
     * )
     */
    public function getprofilsortie(SerializerInterface $serializer,ProfilSortiesRepository $repo)
    {
        $PS= $repo->findAll();
        $PSJson =$serializer->serialize($PS,"json",
        [
            "groups"=>["profilsortie:read_All"]
        ]
    );
        return new JsonResponse($PSJson,Response::HTTP_OK,[],true);
    }

    /**
     * @Route(
     * name="new_profilsortie",
     * path="api/admin/profilsorties",
     * methods={"POST"},
     * defaults={
    * "_controller"="\App\Controller\ProfilSortieController::postprofilsortie",
     * "_api_resource_class"=ProfilSorties::class,
     * "_api_collection_operation_name"="post_profilsortie"
     * }
     * )
     */
    public function postprofilsortie(SerializerInterface $serializer,Request $request,ValidatorInterface $validator)
    {
        $profilS = $request->getContent();
        $profilS = $serializer->deserialize($profilS, ProfilSortie::class, 'json');
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorsString =$serializer->serialize($errors,"json");
            return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($profilS);
        $entityManager->flush();
        return new JsonResponse("vous avez ajouter un profil de sortie avec succes",Response::HTTP_CREATED,[],true);
    }


     /**
     * @Route(
     * name="profilssorties_by_id",
     * path="api/profilsorties/{id}",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\ProfilSortieController::getprofilsortiesById",
     * "_api_resource_class"=ProfilSorties::class,
     * "_api_collection_operation_name"="get_profilsortie_by_id_apprenants"
     * }
     * )
     */
    public function getprofilsortieById(ProfilSortiesRepository $repo, int $id)
    {
        $profilsorties= $repo->findByProfilSortieById($id);
        return $this->json($profilsorties,Response::HTTP_OK);
    }


    /**
     * @Route(
     * name="profilsorties_by_id",
     * path="api/profilsorties/{id}/apprenant",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\ProfilSortieController::showprofilsortieById",
     * "_api_resource_class"=ProfilSorties::class,
     * "_api_collection_operation_name"="get_profilsortie_by_id"
     * }
     * )
     */
    public function showprofilsortieById(ProfilSortiesRepository $repo, int $id)
    {
        $profilsortie= $repo->findByProfilSortiesById($id);
        return $this->json($profilsortie,Response::HTTP_OK);
    }

}
