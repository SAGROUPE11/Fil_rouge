<?php

namespace App\Controller;

use\App\Entity\User;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ApprenantController extends AbstractController
{
    /**
     * @Route(
     * name="apprenant_liste",
     * path="api/apprenants",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\ApprenantController::showApprenant",
     * "_api_resource_class"=User::class,
     * "_api_collection_operation_name"="get_apprenants"
     * }
     * )
     */
    public function showApprenant(ApprenantRepository $repo)
    {
        $apprenants= $repo->findByApprenant("Apprenant");
        return $this->json($apprenants,Response::HTTP_OK);
    }
    
    /**
     * @Route(
     *     name="add_apprenant",
     *     path="/api/apprenants",
     *     methods={"POST"},
     *     defaults={
     *          "__controller"="App\Controller\ApprenantController::addApprenant",
     *          "__api_resource_class"=Apprenant::class,
     *          "__api_collection_operation_name"="post_avatar"
     *     }
     * )
     */
    public function addApprenant(Request $request,SerializerInterface $serializer,ValidatorInterface $validator,EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $apprenant = $request->request->all();
        $avatar = $request->files->get("avatar");
        $apprenant = $serializer->denormalize($apprenant,"App\Entity\Apprenant", true);
        $avatar = fopen($avatar->getRealPath(),"rb");
        $errors = $validator->validate($apprenant);
        if (count($errors)){
            $errors = $serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }
        $password = $apprenant ->getPassword();
        $apprenant -> setPassword($encoder -> encodePassword($apprenant, $password));
        $apprenant-> setAvatar($avatar);
        $manager->persist($apprenant);
        $manager->flush();
        fclose($avatar);
        return $this->json("vous avez ajouter un user success",Response::HTTP_CREATED);
    }

    /**
     * @Route(
     * name="apprenants_by_id",
     * path="api/apprenants/{id}",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\ApprenantController::showApprenantById",
     * "_api_resource_class"=User::class,
     * "_api_collection_operation_name"="get_apprenant_by_id"
     * }
     * )
     */
    public function showApprenantById(UserRepository $repo, int $id)
    {
        $user= $repo->findByApprenantById($id);
        return $this->json($user,Response::HTTP_OK);
    }

}
