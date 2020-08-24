<?php

namespace App\Controller;

use\App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormateurController extends AbstractController
{
    /**
     * @Route(
     * name="formateur_liste",
     * path="api/formateurs",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\FormateurController::showFormateur",
     * "_api_resource_class"=User::class,
     * "_api_collection_operation_name"="get_formateurs"
     * }
     * )
     */
    public function showFormateur(UserRepository $repo)
    {
        $formateurs= $repo->findByFormateur("Formateur");
        return $this->json($formateurs,Response::HTTP_OK);
    }
    /**
     * @Route(
     * name="formateur_by_id",
     * path="api/formateurs/{id}",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\FormateurController::showFormateurById",
     * "_api_resource_class"=User::class,
     * "_api_collection_operation_name"="get_formateur_by_id"
     * }
     * )
     */
    public function showFormateurById(UserRepository $repo, int $id)
    {
        $user= $repo->findByFormateurById($id);
        return $this->json($user,Response::HTTP_OK);
    }
}
