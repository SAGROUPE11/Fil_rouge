<?php

namespace App\Controller;

use App\Entity\Niveau;
use App\Repository\NiveauRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NiveauController extends AbstractController
{
    
//<------------------------------------------------------------------------------------->
                    //La liste des niveau
     /**
     * @Route(
     * name="list_niveau",
     * path="api/admin/niveaux",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\NiveauController::showNiveau",
     * "_api_resource_class"=Niveau::class,
     * "_api_collection_operation_name"="get_niveau"
     * }
     * )
     */

    public function showNiveau(NiveauRepository $repot)
    {
        $niveau= $repot->findAll();
        return $this->json($niveau,200);
    }

//<------------------------------------------------------------------------------------->
                    //Ajouter des competences

    /**
     * @Route(
     * name="add_niveau",
     * path="api/admin/niveaux",
     * methods={"POST"},
     * defaults={
     * "_controller"="\App\Controller\NiveauController::postNiveau",
     * "_api_resource_class"=Niveau::class,
     * "_api_collection_operation_name"="post_niveau"
     * }
     * )
     */

    public function postNiveau(SerializerInterface $serializer,Request $request,ValidatorInterface $validator)
    {
        $niveau = $request->getContent();
        $niv = $serializer->deserialize($niveau , Niveau::class, "json");
        $errors = $validator->validate($niv);
        if (count($errors) > 0) {
            $errorsString =$serializer->serialize($errors,"json");
            return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($niv);
        $entityManager->flush();
        return new JsonResponse("Niveau ajouter avec succes", 200);
    }

//<------------------------------------------------------------------------------------->
                    //Obtenir une niveau

/**
     * @Route(
     * name="show_niveau_by_id",
     * path="api/admin/niveaux/{id}",
     * methods={"GET"},
     * defaults={
     * "_controller"="\app\Controller\NiveauController::infoNiveau",
     * "_api_resource_class"=Niveau::class,
     * "_api_collection_operation_name"="get_niveau_by_id"
     * }
     * )
*/
    public function infoNiveau(NiveauRepository $repo, int $id)
    {
        $niveau= $repo->find($id);
        
        return $this->json($niveau,200);
        return $niveau;
    }

//<------------------------------------------------------------------------------------->
                    //Modifier une niveau

/**
     * @Route(
     * name="edit_niveau_by_id",
     * path="api/admin/niveaux/{id}",
     * methods={"PUT"},
     * defaults={
     * "_controller"="\app\Controller\NiveauController::EditNiveau",
     * "_api_resource_class"=Niveau::class,
     * "_api_collection_operation_name"="put_niveau_by_id"
     * }
     * )
    */
    public function EditNiveau(NiveauRepository $repo, int $id):Reponse
    {
        $niveau= $repo->find($id);
        $entityManager=getDoctrine()->getManager();
        $entityManager->persist($niveau);
        $entityManager->flush();
        return $this->json($niveau,200);
    }
}
