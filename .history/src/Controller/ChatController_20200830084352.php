<?php

namespace App\Controller;

use DateTime;
use App\Entity\Chat;
use App\Repository\ChatRepository;
use App\Repository\UserRepository;
use App\Repository\PromoRepository;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChatController extends AbstractController
{



    /**
     * @Route(
     *       path="/api/users/promo/{id}/apprenant/{id_a}/chats",
     *       methods={"POST"},
     *       name="add_chat"
     * )
     */
    public function addChatMessage(
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $manager,
        PromoRepository $promosRepository,
        ApprenantRepository $apprenantRepository,
        UserRepository $userRepository,
        $id, $id_a
    ) {

        $data = $request->request->all();
         
       // $data = json_decode($request->getContent(),true);
        $pieceJoint = $request->files->get("pieceJointes");
        // dd($pieceJoint);    
        //dd($data);
        $chat = new Chat;
        $chat->setMessage($data['message']);
        $chat->setCreatAt(new \DateTime());
        $promo  = $promosRepository->findById($id);
        if($promo){
            $chat->setPromo($promo[0]);
        }
        else{
            return $this->json("le tag avec id $id n'existe pas", Response::HTTP_BAD_REQUEST);
        }
        $apprenant  = $userRepository->findById($id_a);
        if( $apprenant ){
            $chat->setUser($apprenant[0]);
        }
        else{
            return $this->json("le tag avec id $id n'existe pas", Response::HTTP_BAD_REQUEST);
        }
        if($pieceJoint)
        $pieceJoint = fopen($pieceJoint->getRealPath(), "rb");
        $data["pieceJointes"] = $pieceJoint;
        $chat->setPieceJointes($data["pieceJointes"]);
        // dd($chat);
        $errors = $validator->validate($chat);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, "json");
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
        }
        $manager->persist($chat);
        $manager->flush();

        //dd();
        
        return $this->json(($chat), Response::HTTP_CREATED);
       
        
    }

    
    /**
     * @Route(
     *       path="/api/users/promo/{id}/apprenant/{id_a}/chats",
     *       methods={"GET"},
     *       name="get_chat"
     * )
     */
    public function getChat($id, $id_a, 
        ChatRepository $chatRepository,
        SerializerInterface $serializer,
        PromoRepository $promosRepository,
        ApprenantRepository $apprenantRepository,
        UserRepository $userRepository
        )
    {   
       
        $chat = $chatRepository->findByCreateAt();
        dd($chat);
        return $this->json(($chat), Response::HTTP_CREATED,[]);

        
    }
}