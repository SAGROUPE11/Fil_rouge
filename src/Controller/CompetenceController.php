<?php

namespace App\Controller;

use App\Entity\Niveau;
use App\Entity\Competences;
use App\Repository\CompetenceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompetenceController extends AbstractController
{

     /**
     * @Route(
     * name="list_competence",
     * path="api/admin/competences",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\CompetenceController::showCompetence",
     * "_api_resource_class"=Competences::class,
     * "_api_collection_operation_name"="get_competences"
     * }
     * )
     */

    public function showCompetence(CompetenceRepository $repo)
    {
        $competences= $repo->findAll();
        return $this->json($competences,200);
    }

//<------------------------------------------------------------------------------------->
                    //Ajouter des competences

    /**
     * @Route(
     * name="add_competence",
     * path="api/admin/competences",
     * methods={"POST"},
     * defaults={
     * "_controller"="\App\Controller\CompetenceController::postCompetence",
     * "_api_resource_class"=Competences::class,
     * "_api_collection_operation_name"="post_competences"
     * }
     * )
     */

    public function postCompetence(SerializerInterface $serializer,Request $request,ValidatorInterface $validator)
    {
        $competence = $request->getContent();
        //$niveau= new Niveau();
        $compt = $serializer->deserialize($competence , Competences::class, 'json');
        //$niv=$serializer->deserialize($niveau , Niveau::class, 'json');

        $errors = $validator->validate($compt);
        if (count($errors) > 0) {
            $errorsString =$serializer->serialize($errors,"json");
            return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($compt);
        //$entityManager->persist($niv);
        $entityManager->flush();
        return new JsonResponse("Competence ajouter avec succes", 200);
    }

//<------------------------------------------------------------------------------------->
                    //Obtenir une competences

/**
     * @Route(
     * name="show_competence_by_id",
     * path="api/admin/competences/{id}",
     * methods={"GET"},
     * defaults={
     * "_controller"="\app\Controller\CompetenceController::infoCompetence",
     * "_api_resource_class"=Competences::class,
     * "_api_collection_operation_name"="get_competence_by_id"
     * }
     * )
*/
    public function infoCompetence(CompetenceRepository $repo, int $id)
    {
        $competence= $repo->find($id);
        
        return $this->json($competence,200);
    }         
//<------------------------------------------------------------------------------------->
                    //Modifier une competences

 /**
         * @Route(
         * name="edit_competence",
         * path="api/admin/competences/{id}",
         * methods={"PUT"},
         * defaults={
         * "_controller"="\app\ControllerCompetenceController::EditCompetence",
         * "_api_resource_class"=Competences::class,
         * "_api_collection_operation_name"="edit_competence_by_id"
         * }
         * )
     */
    // public function EditCompetence(CompetenceRepository $repo, int $id):Reponse
    // {
    //     $competence= $repo->find($id);
    //     $entityManager=getDoctrine()->getManager();
    //     $entityManager->persist($competence);
    //     $entityManager->flush();
    //     return $this->json($competence,200);
    // }

    public function EditCompetence(Request $request, SerializerInterface $serializer, Competences $niveau, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $niveauUpdate = $entityManager->getRepository(Competences::class)->find($niveau->getId());
         $data = json_decode($request->getContent());
         foreach ($data as $key => $value){
             if($key && !empty($value)) {
                 $name = ucfirst($key);
                 $setter = 'set'.$name;
                 $niveauUpdate->$setter($value);
             }
         }
       
        $errors = $validator->validate($niveauUpdate);
        if (count($errors) > 0) {
            $errorsString =$serializer->serialize($errors,"json");
            return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
        }
        $entityManager->flush();
        return new JsonResponse("Competence modifier avec succes", 200);

    }

//<------------------------------------------------------------------------------------->
                    //Supprimer une competences

                    /**
         * @Route(
         * name="delete_competence",
         * path="api/admin/competences/{id}",
         * methods={"DELETE"},
         * defaults={
         * "_controller"="\app\ControllerCompetenceController::DeleteCompetence",
         * "_api_resource_class"=Competences::class,
         * "_api_collection_operation_name"="delete_competence_by_id"
         * }
         * )
     */
    public function DeleteCompetence(CompetenceRepository $repo, int $id):Reponse
    {
        
        $competence= $repo->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($competence);
        $entityManager->flush();
        
         return  $this->Json("Competence supprimer avec succés",200);
    }

    /**
     * @Route(
     * name="grpecompetence_by_id",
     * path="/api/admin/referentiels/{id1}/grpecompetences/{id2}",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\CompetenceController::getCbyG",
     * "_api_resource_class"=Competences::class,
     * "_api_collection_operation_name"="get_grpecompetence_by_id"
     * }
     * )
     */

    public function getCbyG (CompetenceRepository $repo, int $id1, int $id2 )
    {
        $ref= $repo->getCbyGbyRef($id1,$id2);
        return $this->json($ref,Response::HTTP_OK);
    }
}
