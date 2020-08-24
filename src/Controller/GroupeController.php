<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Repository\GroupeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupeController extends AbstractController
{
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
}
