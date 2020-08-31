<?php

namespace App\Controller;

use App\Entity\GroupeCompetences;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\GroupeCompetencesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GrpeCompetencesController extends AbstractController
{

    //pour afficher les groupes de copetences et les competences seulement
     /**
     * @Route(
     * name="grpecompetences_liste",
     * path="api/admin/grpecompetences/competences",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\GrpeCompetencesController::showgrpeCompetence",
     * "_api_resource_class"=GroupeCompetences::class,
     * "_api_collection_operation_name"="get_grpecompetences"
     * }
     * )
     */
    public function showgrpeCompetence(GroupeCompetencesRepository $repo)
    {
        $grpecomp= $repo->findBygrpCompetence();
        return $this->json($grpecomp,Response::HTTP_OK);
    }

    //pour afficher les groupes de copetences, les competences et les niveaux
     /**
     * @Route(
     * name="grpecompetence_liste",
     * path="api/admin/grpecompetences",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\GroupeCompetencesController::getgrpecompetence",
     * "_api_resource_class"=GroupeCompetences::class,
     * "_api_collection_operation_name"="get_grpecompetence"
     * }
     * )
     */
    public function getgrpecompetence(SerializerInterface $serializer,GroupeCompetencesRepository $repo)
    {
        $grpcomp= $repo->findByGrpComp();
        $grcompJson =$serializer->serialize($grpcomp,"json",
        [
            "groups"=>["groupecompetence:read_All"]
        ]
    );
        return new JsonResponse($grcompJson,Response::HTTP_OK,[],true);
    }

    //pour ajouter  groupe de copetences 
    /**
     * @Route(
     * name="new_grpecompetence",
     * path="api/admin/grpecompetences",
     * methods={"POST"},
     * defaults={
     * "_controller"="\App\Controller\GrpeCompetencesController::postgrpecompetence",
     * "_api_resource_class"=GroupeCompetences::class,
     * "_api_collection_operation_name"="post_grpecompetence"
     * }
     * )
     */

    public function postgrpecompetence(SerializerInterface $serializer,Request $request,ValidatorInterface $validator)
    {
        $grpecompetence = $request->getContent();
        $grpcomp = $serializer->deserialize($grpecompetence, GroupeCompetences::class, 'json');
        $errors = $validator->validate($grpcomp);
        if (count($errors) > 0) {
            $errorsString =$serializer->serialize($errors,"json");
            return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($grpcomp);
        $entityManager->flush();
        return new JsonResponse("vous avez ajouter un groupe de competences avec succes",Response::HTTP_CREATED,[],true);
    }

//pour afficher un groupe de copetences, les competences et les competences via l'id
     /**
     * @Route(
     * name="grpecompetences_by_id",
     * path="api/grpecompetences/{id}",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\GrpeCompetencesController::getgrpeCompetenceById",
     * "_api_resource_class"=GroupeCompetences::class,
     * "_api_collection_operation_name"="get_grpecompetence_by_id_competences"
     * }
     * )
     */
    public function getgrpeCompetenceById(GroupeCompetencesRepository $repo, int $id)
    {
        $grpeCompetences= $repo->findByGroupeCompetencesById($id);
        return $this->json($grpeCompetences,Response::HTTP_OK);
    }

    //Affiche les compétences d'un groupe sans les niveaux
    /**
     * @Route(
     * name="grpecompetences_by_id",
     * path="api/grpecompetences/{id}/competences",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\GrpeCompetencesController::showgrpeCompetenceById",
     * "_api_resource_class"=GroupeCompetences::class,
     * "_api_collection_operation_name"="get_grpecompetence_by_id"
     * }
     * )
     */
    public function showgrpeCompetenceById(GroupeCompetencesRepository $repo, int $id)
    {
        $grpeCompetences= $repo->findByGroupeCompetencesById($id);
        return $this->json($grpeCompetences,Response::HTTP_OK);
    }

    /**
     * @Route(
     * name="grpcompetence_liste",
     * path="/api/admin/referentiels/grpecompetences",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\GrpeCompetencesController::showgrpeCompetences",
     * "_api_resource_class"=GroupeCompetences::class,
     * "_api_collection_operation_name"="get_grpcompetence"
     * }
     * )
     */

    public function showgrpeCompetences(GroupeCompetencesRepository $repo)
    {
        $grcompetence= $repo->findGRCComp();
        return $this->json( $grcompetence,Response::HTTP_OK);
    }

}
