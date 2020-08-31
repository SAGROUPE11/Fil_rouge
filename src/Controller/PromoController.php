<?php

namespace App\Controller;

use App\Entity\Promo;
use App\Entity\Groupe;
use App\Entity\Niveau;
use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Entity\Referenciel;

use App\Repository\PromoRepository;
use App\Repository\GroupeRepository;
use App\Repository\ProfilRepository;
use App\Repository\ApprenantRepository;
use App\Repository\FormateurRepository;
use App\Repository\ReferencielRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PromoController extends AbstractController
{
//<------------------------------------------------------------------------------------->
                            //Liste promo    
    /**
     * @Route(
     * name="promo_liste",
     * path="api/admin/promo",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\PromoController::getpromo",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="get_promo"
     * }
     * )
     */
    
    Public function getpromo(PromoRepository $repo)
    {
        $promo= $repo->findByPromo();
        return $this->json($promo,Response::HTTP_OK);
    }

//<------------------------------------------------------------------------------------->
                            //Liste promo principal

    /**
     * @Route(
     * name="promo_list",
     * path="api/admin/promo/principal",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\PromoController::getpromoprincipal",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="get_promotion"
     * }
     * )
     */
    
    Public function getpromoprincipal(SerializerInterface $serializer,PromoRepository $repo)
    {
            $promo=$repo->findGroupePrincipal();
            
            $principal=$serializer->serialize($promo,"json",
        [
            "groups"=>["promo:principal_read"]
        ]
    );
   
    return new JsonResponse($principal,Response::HTTP_OK,[],true);
    }

     /**
     * @Route(
     * name="liste_attentes",
     * path="api/admin/promo/apprenants/attentes",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\PromoController::ListeAttente",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="get_Liste_attentes"
     * }
     * )
     */
    
    Public function ListeAttente(SerializerInterface $serializer,PromoRepository $repo)
    {
        $promos= $repo->findAll();
        //dd($promos);
        $enAttente = [];
        foreach ($promos as $promo)
        {
            // dd($promo);
            $referenciel = $promo->getReferenciel();         
            //  dd($referenciel);
            $groupes= $promo->getGroupe();
            // $app = $promo->getApprenant();
            // dd($app);
            foreach ($groupes as $groupe)
            {
                if(!$groupe->getIsDeleted()){
                $apprenant = $groupe->getApprenants();
               // dd($apprenant);
                foreach ($apprenant as $apprenants)
                {
                    if ($apprenants->getEnAttente())
                    {
                        $enAttente[] = $promo;
                        //dd($enAttente);
                    }
                }

            }
         }
        }
        return $this->json($enAttente,Response::HTTP_OK,[
            "groups"=>["promo:attente_read"]
        ]);        
    }
    
     /**
     * @Route(
     *     path="/api/admin/promos",
     *     methods={"POST"},
     *     name="addPromo"
     * )
     */
    public function addPromo(SerializerInterface $serializer, Request $request,ReferencielRepository $repoRefer, ProfilRepository $profilRepo)
    {
        $profFormateur=$profilRepo->find(2);
        $promoAjout=json_decode($request->getContent(),true);
        $promo=new Promo();
        $promoRef=new Referenciel();
//        $this->denyAccessUnlessGranted('POST_EDIT',$promo);

        $groupeAdd=json_decode($request->getContent(),true);
        $promo->setLangue($promoAjout['langue']);
        $promo->setTitre($promoAjout['titre']);
        $promo->setDescription($promoAjout['description']);
        $promo->setLieu($promoAjout['lieu']);
        $promo->setDateDebut(new \DateTime());
        $promo->setDateFinProvisoire(new \DateTime());
        $promo->setFabrique($promoAjout['fabrique']);
        $promo->setDateFinReelle(new \DateTime());
        $promo->setEtat($promoAjout['etat']);
        $promo->addReferenciel($promoRef);

//dd($promoAjout['referenciel']);
        $profil=$profilRepo->find(1);
        $referenciel=$repoRefer->findOneBy([
            "id"=>$promoAjout['referenciel']]);
            // dd($referenciel);
        if($referenciel){
            $promo->setReferentiel($referentiel);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($promo);
        $entityManager->flush();
        return $this->json($promo,Response::HTTP_CREATED,"json");
    }
/**
     * @Route(
     * name="show_promo_by_id",
     * path="api/admin/promo/{id}",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\PromoController::getPromoById",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="get_promo_by_id"
     * }
     * )
     */
    
    Public function getPromoById($id, PromoRepository $repo)
   {
    $promo = $repo->findOneBy([
        "id" => $id
    ]);
    // dd($promo);
    if($promo){
        // if (!$promo->getIsDeleted())
            return $this->json($promo,Response::HTTP_OK,[
                "groups"=>["promo:read"]
            ]);
    }
    return $this->json(["message" => "Ressource inexistante"],Response::HTTP_NOT_FOUND);

    }

    /**
     * @Route(
     * name="showPromoPrincipalById",
     * path="api/admin/promo/{id}/principal",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\PromoController::getPromoPrincipalById",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="getPromoPrincipalById"
     * }
     * )
     */
    
    Public function getPromoPrincipalById($id,SerializerInterface $serializer, PromoRepository $repo)
    {
        // $promo= $repo->findByPromo();
        // return $this->json($promo,Response::HTTP_OK);
        $promo = $repo->find($id);
        //  dd($promo['groupe']);
        $promoJson = $serializer->serialize($promo, 'json',["groups"=>["promo:read_All"]]);
        //   dd($promoJson);
       
        return new JsonResponse($promoJson, Response::HTTP_OK, [], true);
    }

    /**
     * @Route(
     * name="showPromoRefentielById",
     * path="api/admin/promo/{id}/referentiels",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\PromoController::showPromoRefentielById",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="getPromoRefentielById"
     * }
     * )
     */
    
    Public function showPromoRefentielById($id,PromoRepository $repo,SerializerInterface $serializer)
    {
        $promo= $repo->find($id);
        $promoJson = $serializer->serialize($promo, 'json',["groups"=>["promo:read_CRGrp_C"]]);
        // dd($promoJson);
        return new JsonResponse($promoJson, Response::HTTP_OK, [], true);
    }

    /**
     * @Route(
     * name="showApprenantAttenteById",
     * path="api/admin/promo/{id}/apprenants/attente",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\PromoController::getApprenantAttenteById",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="getApprenantAttenteById"
     * }
     * )
     */
    
   Public function getApprenantAttenteById($id, PromoRepository $repo)
    {
        $promo = $repo->findOneBy([
            "id" => $id
        ]);
        // dd($promo);
        $en_attente = [];
        if ($promo) {
            $referenciel = $promo->getReferenciel(); 
            // dd($referenciel);
            $en_attente[]=$referenciel;
            // $groupe = $promo->getGroupe();
            $apprenants=$promo->getApprenant();
            $apprenants=new Apprenant();
             dd($apprenants->getEmail());
            // $students = $groupes->getApprenant();
            
            foreach ($apprenants as $apprenant => $value)
                
                // $promoTab = $this->serializer->deserialize($value, Promos::class,"json");
                // dd($promoTab);
                {
                    $en_attente[] = $value;
                }
            
            return $this->json($en_attente,Response::HTTP_OK);
        }
        
        return $this->json("Une erreur est survenue lors du chargement de cette ressource",Response::HTTP_NOT_FOUND);
    }


    /**
     * @Route(
     * name="showGroupeApprenantById",
     * path="api/admin/promo/{id1}/groupes/{id2}/apprenants",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\PromoController::getGroupeApprenantById",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="getGroupeApprenantById"
     * }
     * )
     */
    
    Public function getGroupeApprenantById(PromoRepository $repoPromo, GroupeRepository $repoGroupe, int $id1, int $id2, SerializerInterface $serializer)
    {
        $promo= $repoPromo->find($id1);
        // dd($promo);
        $groupe= $repoGroupe->find($id2);
       // dd($Groupe);
       $PromoGroupe=$promo->getGroupe();
    //    dd($PromobGroupe);
       foreach ($PromoGroupe as  $value) {
        if ($value != $groupe) {
            $promo->removeGroupe($value);
        }
        // dd($promo);
    }

        $GroupeApprenant = $serializer->serialize($promo, 'json',["groups"=>["promo_groupe_apprenant:read"]]);
        //  dd($GroupeApprenant);
        return new JsonResponse($GroupeApprenant, Response::HTTP_OK, [], true);
    }


    /**
     * @Route(
     * name="showFormateurById",
     * path="api/admin/promo/{id}/formateurs",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\PromoController::getFormateur",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="getFormateurById"
     * }
     * )
     */
    
   Public function getFormateur(int $id, PromoRepository $repo,SerializerInterface $serializer)
    {
        $promoformateur= $repo->find($id);
        // dd($promoformateur);
        if(!$promoformateur){
            return new JsonResponse("Cette promo n'existe pas", Response::HTTP_FORBIDDEN);
        }

        $Result = $serializer->serialize($promoformateur, 'json',["groups"=>["promo_formateur:read"]]);
        return new JsonResponse($Result, Response::HTTP_OK, [], true);
    }  
}