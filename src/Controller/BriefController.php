<?php

namespace App\Controller;

use App\Entity\Briefs;
use App\Repository\BriefRepository;
use App\Repository\PromoRepository;
use App\Repository\GroupeRepository;
use App\Repository\NiveauRepository;
use App\Repository\ApprenantRepository;
use App\Repository\FormateurRepository;
use App\Repository\RessourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReferencielRepository;
use App\Repository\BriefMaPromoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\LivrablesAttendusRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BriefController extends AbstractController
{
    // Constructeur Sylla
    private $manager,
    $serializer, $validator,
    $repoPromo, $repoFormateur,
    $groupeRepo, $encoder,
    $repoBrief,$repoNiveau,
    $repoReferentiel,$repoLivrableAttendus,
    $ressource;
public function __construct(UserPasswordEncoderInterface $encoder,PromoRepository $repoPromo, 
FormateurRepository $repoFormateur,BriefRepository $repoBrief, 
ValidatorInterface $validator,EntityManagerInterface $manager,
SerializerInterface $serializer,GroupeRepository $groupeRepo, LivrablesAttendusRepository $repoLivrableAttendus,
NiveauRepository $repoNiveau, ReferencielRepository $repoReferentiel, RessourceRepository $ressource)
{
        $this->serializer = $serializer;
        $this->repoBrief = $repoBrief;
        $this->manager = $manager;
        $this->validator = $validator;
        $this->groupeRepo = $groupeRepo;
        $this->repoPromo=$repoPromo;
        $this->repoFormateur=$repoFormateur;
        $this->repoLivrable=$repoLivrableAttendus;
        $this->encoder=$encoder;
        $this->repoNiveau=$repoNiveau;
        $this->repoReferentiel=$repoReferentiel;
        $this->repoRessource=$ressource;
}


     /**
     * @Route(
     *     name="show_promo_id_groupe_id_briefs",
     *     path="api/formateurs/promo/{id_promo}/groupe/{id_groupe}/briefs",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Briefs::class,
     *         "_api_collection_operation_name"="get_promo_id_groupe_id_briefs"
     *     }
     * )
     */
    public function getFormateurPromoGroupeBrief(SerializerInterface $serializer, int $id_promo, int $id_groupe, 
    PromoRepository $repoPromo, BriefRepository $repoBrief, GroupeRepository $ripoGroupe)
    {
        $promo = $repoPromo->find($id_promo);
        if (empty($promo)) {
            return new JsonResponse("La promo est obligatoire", Response::HTTP_NOT_FOUND, [], true);
        }

        $groupe = $ripoGroupe->find($id_groupe);
        if (empty($groupe) || !$promo->getGroupe()->contains($groupe)) {
            return new JsonResponse("Veillez renseigner un groupe existant.", Response::HTTP_NOT_FOUND, [], true);
        }

        $briefJson = $serializer->serialize($groupe, 'json', ["groups" => ["brief_Groupe:read"]]);
        return new JsonResponse($briefJson, Response::HTTP_OK, [], true);
    }

     /**
     * @Route(
     *     name="show_promo_id_briefs",
     *     path="api/formateurs/promo/{id_promo}/briefs",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Briefs::class,
     *         "_api_collection_operation_name"="get_promo_id_briefs"
     *     }
     * )
     */

    public function getFormateurPromoBrief(SerializerInterface $serializer, int $id_promo, 
    PromoRepository $repoPromo, BriefRepository $repoBrief, GroupeRepository $ripoGroupe)
    {
        $promo = $repoPromo->find($id_promo);
        if (empty($promo)) {
            return new JsonResponse("Ressource inexistante", Response::HTTP_NOT_FOUND, [], true);
        }

        $promoJson = $serializer->serialize($promo, 'json', ["groups" => ["brief_Groupe:read"]]);
        return new JsonResponse($promoJson, Response::HTTP_OK, [], true);
    }

    /**
     * @Route(
     *     name="show_FormateurBrouillonBrief",
     *     path="api/formateurs/{id}/briefs/brouillons",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Briefs::class,
     *         "_api_collection_operation_name"="get_FormateurBrouillonBrief"
     *     }
     * )
     */

    public function getFormateurBrouillonBrief(SerializerInterface $serializer, int $id, PromoRepository $repoPromo, BriefMaPromoRepository $repoBriefMaPromo,
     FormateurRepository $repoFormateur, BriefRepository $repoBrief, GroupeRepository $ripoGroupe)
    {
        $formateur = $repoFormateur->find($id);
        if (empty($formateur)) {
            return new JsonResponse("Veillez renseigner un formateur existant.", Response::HTTP_NOT_FOUND, [], true);
        }

        foreach ($formateur->getBrief() as $value) {
            if ($value->getEtatBrief()->getLibelle() != "Brouillon") {
                $formateur->removeBrief($value);
            }
        }

        if (count($formateur->getBrief()) < 1) {
            return new JsonResponse("Brouillon vide.", Response::HTTP_NOT_FOUND, [], true);
        }

        $briefJson = $serializer->serialize($formateur->getBriefs(), 'json', ["groups" => ["brief_Groupe:read"]]);
        return new JsonResponse($briefJson, Response::HTTP_OK, [], true);
    }

    /**
     * @Route(
     *     name="show_FormateurValideBrief",
     *     path="api/formateurs/{id}/briefs/valide",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Briefs::class,
     *         "_api_collection_operation_name"="get_FormateurValideBrief"
     *     }
     * )
     */

    public function getFormateurValideBrief(SerializerInterface $serializer, int $id, PromoRepository $repoPromo, BriefMaPromoRepository $repoBriefPromo, 
    FormateurRepository $repoFormateur, BriefRepository $repoBrief, GroupeRepository $ripoGroupe)
    {
        $formateur = $repoFormateur->find($id);
        if (empty($formateur)) {
            return new JsonResponse("Ressource inexistante.", Response::HTTP_NOT_FOUND, [], true);
        }

        foreach ($formateur->getBrief() as $value) {
            if ($value->getEtatBrief()->getLibelle() != "Valide" && $value->getEtatBrief()->getLibelle() != "Non-assigne") {
                $formateur->removeBrief($value);
            }
        }

        if (count($formateur->getBrief()) < 1) {
            return new JsonResponse("Aucun brief valide.", Response::HTTP_NOT_FOUND, [], true);
        }

        $briefJson = $serializer->serialize($formateur->getBrief(), 'json', ["groups" => ["brief_Groupe:read"]]);
        return new JsonResponse($briefJson, Response::HTTP_OK, [], true);
    }

     /**
     * @Route(
     *      name="show_promoIdBriefId", 
     *      path="api/formateurs/promo/{id_promo}/briefs/{id_brief}", 
     *      methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Briefs::class,
     *         "_api_collection_operation_name"="get_promo_id_brief_id"
     *     }
     * )
     */
    public function getBriefByPromo(SerializerInterface $serializer, int $id_promo, int $id_brief, PromoRepository $repoPromo, BriefRepository $repoBrief)
    {

        $promo = $repoPromo->find($id_promo);
        if (empty($promo)) {
            return new JsonResponse("La ressource promo est inexistante.", Response::HTTP_NOT_FOUND, [], true);
        }

        $brief = $repoBrief->find($id_brief);

        if (!($brief)) {
            return new JsonResponse("Ce brief n'existe pas.", Response::HTTP_NOT_FOUND, [], true);
        }


        $briefJson = $serializer->serialize($brief, 'json', ["groups" => ["brief_Groupe:read"]]);
        return new JsonResponse($briefJson, Response::HTTP_OK, [], true);
    }

     /**
     * @Route(
     *      name="show_briefByPromoIdApprenant",
     *      path="api/apprenants/promo/{id_promo}/briefs",  
     *      methods="GET",
     *      defaults={
     *         "_api_resource_class"=Briefs::class,
     *         "_api_collection_operation_name"="get_brief_by_promo_Id_apprenant"
     *     }  
     * )
     */
    public function getBriefByPromoIdApprenant(SerializerInterface $serializer, int $id_promo, PromoRepository $repoPromo, BriefRepository $repoBrief, GroupeRepository $ripoGroupe)
    {
        $promo = $repoPromo->find($id_promo);
        if (empty($promo)) {
            return new JsonResponse("Ce promo n'existe pas.", Response::HTTP_NOT_FOUND, [], true);
        }

        foreach ($promo->getBriefMaPromos() as $value) {
            if ($value->getBriefs()->getEtatBrief()->getLibelle() != "Assigne") {
                $promo->removeBriefMaPromo($value);
            }
        }

        $promoJson = $serializer->serialize($promo, 'json', ["groups" => ["brief_Groupe:read"]]);
        return new JsonResponse($promoJson, Response::HTTP_OK, [], true);
    }


    // Annotation et Fonction Sylla

     /**
     * @Route(
     * name="add_formateur_brief",
     * path="formateurs/briefs/{id}",
     * methods={"POST"}
     * )
     */

    public function addFormateurBrief(Request $request, int $id)
    {   
        $findId= $this->repoBrief->findOneBy([
            "id"=>$id]);
            //dd($findId);
            // dd($findId->getTitre());
        if($findId){
            $brief= new Briefs();
            foreach ($brief->getPromo() as  $value) {
                # code...
                $brief->removePromo($value);
            }
        $brief->setTitre($findId->getTitre())
                 ->setEnonce($findId->getEnonce())
                 ->setContexte($findId->getContexte())
                 ->setCreatedAt($findId->getCreatedAt())
                 ->setDateEcheance($findId->getDateEcheance())
                 ->setEtat("Complete")
                ;
        //    dd($brief);
            
            $this->manager->persist($brief);
            $this->manager->flush();                     
        return new JsonResponse("Vous avez dupliquer une brief avec succes",Response::HTTP_CREATED,[],true);
        }
        
            return new JsonResponse("Cette ressource n'existe pas",Response::HTTP_NOT_FOUND);
    }


      
     /**
     * @Route(
     * name="add_groupe_apprenant",
     * path="apprenants/{id_apprenant}/groupe/{id_groupe}/livrables",
     * methods={"POST"}
     * )
     */


    public function addApprenantGroupe(Request $request, int $id_apprenant, int $id_groupe, ApprenantRepository $repo, LivrablesAttendusRepository $repoLA)
    {
         $apprenant = $repo->findOneBy([
             "id"=>$id_apprenant]);
            //  dd($apprenant);
         $groupe =  $this->groupeRepo->findOneBy([
             "id"=>$id_groupe]);
            //   dd($groupe);
            $groupeApprenants=$groupe->getApprenants();
            if (!$apprenant) {
                # code...
                return new JsonResponse("L'identifiant de l'apprenant n'existe pas",Response::HTTP_NOT_FOUND);
            }
            elseif (!$groupe) {
                # code...
                return new JsonResponse("Cette groupe n'existe pas",Response::HTTP_NOT_FOUND);
            }
            else{
                foreach ($groupeApprenants as $groupeApprenant) {
                if ($groupeApprenant == $apprenant) {
                    $livrableAttendu = new LivrablesAttenduApprenant();
                    $JsonContent = $request->getContent();
                    $TabContent = $this->serializer->decode($JsonContent, "json"); 
                    // dd($TabContent);
                    $getId=$livrableAttendu->getId();
                    //  dd($getId);
                    $livrableAttenduApprenant = $repoLA->findOneBy(["id"=>$getId]);
                    if ($livrableAttenduApprenant){
                        $livrableAttendu->setLivrableAttendu($livrableAttenduApprenant);
                        
                    }
                    if ($TabContent["url"]) {
                        $livrableAttendu->setUrl($TabContent["url"]);
                        $samaGroupes = $apprenant->getGroupe();
                        foreach ($samaGroupes as $samaGroupe) {
                            $apprenants = $samaGroupe->getApprenants();
                            foreach ($apprenants as $value) {
                                $livrables=$value->getLivrablesAttenduApprenants();
                                foreach ($livrables as $livrable) {
                                    $livrable->setUrl($contentTab["url"]);                        
                            }
                        }
                    }
                }
                $livrableAttendu->addLivrablesAttenduApprenant($livrableAttenduApprenant);
                $livrableAttendu->setApprenant($apprenant);
                $this->manager->persist($livrableAttendu);
                $this->manager->flush();    
                return new JsonResponse("Livrable ajouter avec succes",Response::HTTP_CREATED,[],true); 
            }
            else{
                return new JsonResponse("L'apprenant n'est pas dans cette groupe",Response::HTTP_NOT_FOUND); 
            }
        }
     }

    }
}
