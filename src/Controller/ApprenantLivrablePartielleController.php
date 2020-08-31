<?php

namespace App\Controller;

use App\Entity\ApprenantLivrablePartielle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ApprenantRepository;
use App\Repository\LivrablePartielRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ApprenantLivrablePartielleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;


class ApprenantLivrablePartielleController extends AbstractController
{
    /**
     * @Route(
     *     name="put_etat_apprenants",
     *     path="/api/apprenants/{id_app}/livrablepartiels/{id_livrable}",
     *     methods={"PUT"},
     *     defaults={
     *          "__controller"="App\Controller\ApprenantLivrablePartielController::modif_etat",
     *          "__api_resource_class"=ApprenantLivrablePartiel::class,
     *          "__api_collection_operation_name"="add_etat_apprenants"
     *     }
     * )
     */

    public function modif_etat(Request $request, EntityManagerInterface $em, int $id_app, int $id_livrable, ApprenantLivrablePartielleRepository $repolivpartielle)
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['etat']) || empty($data['etat'])) {
            return new JsonResponse("Veuillez remplir le statut.", Response::HTTP_BAD_REQUEST, [], true);
        }

        $statut = $repolivpartielle->findBy(["apprenant"=>$id_app,"livrablePartiel"=>$id_livrable]);

        if (empty($statut)) {
            return new JsonResponse("Cet statut n'existe pas.", Response::HTTP_NOT_FOUND, [], true);
        }
        //dd($data);
        foreach ($statut as $value) {

            $value->setEtat($data["etat"]);
            $em->persist($value);
        }

        $em->flush();
        return new JsonResponse("Statut Changer", Response::HTTP_CREATED, [], true);
    }

}
