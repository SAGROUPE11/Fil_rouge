<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Repository\GroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class GroupeController extends AbstractController
{
  private $em;
    //<------------------------------------------------------------------------------------->
                    //La liste des groupes
     /**
     * @Route(
     * name="list_groupe",
     * path="api/admin/groupes",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\GroupeController::showGroupe",
     * "_api_resource_class"=Groupe::class,
     * "_api_collection_operation_name"="get_groupes"
     * }
     * )
     */

    public function showGroupe(GroupeRepository $repo)
    {
        $groupe= $repo->findAll();
        
        return $this->json($groupe,200);
    }

    //<------------------------------------------------------------------------------------->
                    //La liste des groupes
     /**
     * @Route(
     * name="show_groupes_by_id",
     * path="api/admin/groupes/{id}",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\GroupeController::infoGroupe",
     * "_api_resource_class"=Groupe::class,
     * "_api_collection_operation_name"="get_groupe_by_id"
     * }
     * )
     */

    public function infoGroupe(GroupeRepository $repo, int $id)
    {
        $groupe= $repo->find($id);
        
        return $this->json($groupe,200);  
      }

    /**
     * @Route(
     * name="groupe_write",
     * path="api/admin/groupes",
     * methods={"POST"},
     * defaults={
     * "_controller"="\App\Controller\GroupeController::postgroupe",
     * "_api_resource_class"=Groupe::class,
     * "_api_collection_operation_name"="post_groupe"
     * }
     * )
     */
    public function postgroupe(SerializerInterface $serializer, Request $request)
    {
        $groupe = $request->getContent();
        $admin = $serializer->deserialize($groupe, Groupe::class, 'json');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($admin);
        $entityManager->flush();
        return new JsonResponse("succes",Response::HTTP_CREATED,[],true);
    }

    /**
     * @Route(
     * name="app_gr_write",
     * path="/api/admin/groupes/{id}",
     * methods={"PUT"},
     * defaults={
     * "_controller"="\App\Controller\GroupeController::postgr_app",
     * "_api_resource_class"=Groupe::class,
     * "_api_collection_operation_name"="post_app_gr"
     * }
     * )
     */

    public function postgr_app($id,$iden)
    {
        $groupe = $this->grpeRepo->findOneBy([
            "id"=>$id
        ]);
        $apprenants = $groupe->getApprenants();
        $apprenantId = $this->apprenantRepo->findOneBy([
            "id"=>$iden
        ]);
        if($apprenants->contains($apprenantId)){
            return new Response("Cet Apprenant existe deja dans le groupe");
        }
        $data = $groupe->addApprenant($apprenantId);
        $this->manager->persist($data);
        $this->manager->flush();
        return new Response("L'apprenant a ete ajouté avec succés");
    }

    /**
     * @Route(
     *     name="delete_apprenant_groupe",
     *     path="/api/admin/groupes/{id_groupe}/apprenants/{id_apprenant}",
     *     methods={"DELETE"},
     *     defaults={
     * "_controller"="\App\Controller\GroupeController::deleteApprenantGroupe",
     * "_api_resource_class"=Groupe::class,
     * "_api_collection_operation_name"="delete_apprenant"
     * }
     * )
     */
    public function deleteApprenantGroupe(int $id_groupe, int $id_apprenant, Request $request, EntityManagerInterface $em,  GroupeRepository $repoGroupe)
    {

        // Traitement Groupe
        $groupe = $repoGroupe->find($id_groupe) ;

        // Traitement apprenants

        foreach ($groupe->getApprenants() as $value) {

            if ($value->getId()== $id_apprenant) {
                $groupe->removeApprenant($value);
            }
        }

        $this->em->persist($groupe);
        $this->em->flush();
        return new JsonResponse("success", Response::HTTP_CREATED, [], true);
    }
}
