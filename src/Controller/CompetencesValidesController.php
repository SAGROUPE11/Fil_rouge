<?php

namespace App\Controller;

use App\Entity\Promo;
use App\Entity\Referenciel;
use App\Entity\CompetencesValides;
use App\Repository\CompetencesValidesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CompetencesValidesController extends AbstractController
{
/*
    /**
     * @Route("/api/formateurs/promo/{id_promo}/referentiel/{id_ref}/statistiques/competences", name="show_statistiques_competencesvalid", methods="GET")
     */

  /*  public function StatistiquesCompetencesValid(SerializerInterface $serializer, CompetencesValidesRepository $competencesValidesRepository, $id_promo, $id_ref)
    {
        $touscompetencesValides=$competencesValidesRepository->findBy(["promo"=>$id_promo,"referenciel"=>$id_ref]);
        //dd($competencesValides);
        $tabCompetences=[];
        foreach ($touscompetencesValides as $valide){
            if($valide->getNiveau1()==true && $valide->getNiveau2()==true && $valide->getNiveau3()==true){
                $tabCompetences[]=$valide;
            }
        }
        $commentairesJson = $serializer->serialize($touscompetencesValides, 'json', ["groups" => ["commentencesvalides:read"]]);
        return new JsonResponse($commentairesJson, Response::HTTP_OK, [], true);
    }*/
}
