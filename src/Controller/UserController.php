<?php

namespace App\Controller;

use\App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class UserController extends AbstractController
{
    /**
     * @Route(
     * name="user_By_Profil",
     * path="api/admin/profils/{id}/users",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\UserController::getUserByProfil",
     * "_api_resource_class"=User::class,
     * "_api_collection_operation_name"="get_user_By_Profil"
     * }
     * )
     */
    public function getUserByProfil(UserRepository $repo, int $id)
    {
        $user= $repo->findByUserByProfil($id);
        return $this->json($user,Response::HTTP_OK);
    }

   /**
     * @Route(
     * name="add_user",
     * path="api/users",
     * methods={"POST"},
     * defaults={
     * "_controller"="\App\Controller\UserController::postuser",
     * "_api_resource_class"=User::class,
     * "_api_collection_operation_name"="post_users"
     * }
     * )
     */

    public function postuser(SerializerInterface $serializer,Request $request,ValidatorInterface $validator)
    {
        $user = $request->getContent();
        $user = $serializer->deserialize($user, User::class, 'json');
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorsString =$serializer->serialize($errors,"json");
            return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        return new JsonResponse("vous avez ajouter un user succes",Response::HTTP_CREATED,[],true);
    }

}
