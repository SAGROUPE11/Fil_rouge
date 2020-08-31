<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Tags;
use App\Entity\Promo;
use App\Entity\Briefs;
use App\Entity\Formateur;
use App\Entity\BriefMaPromo;
use App\Repository\TagRepository;
use App\Controller\BriefController;
use App\Repository\BriefRepository;
use App\Repository\PromoRepository;
use App\Repository\GroupeRepository;
use App\Repository\NiveauRepository;
use App\Repository\ApprenantRepository;
use App\Repository\FormateurRepository;
use App\Repository\RessourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\LivrablesAttenduApprenant;
use App\Repository\BriefGroupeRepository;
use App\Repository\ReferencielRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\LivrablesAttendusRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PutBriefController extends AbstractController
{
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
    * name="edit_promo_brief",
    * path="formateurs/promo/{id_promo}/brief/{id_brief}/assignation",
    * methods={"PUT"}
    * )
    */
    Public function EditPromoBrief(int $id_promo, int $id_brief,Request $request, ApprenantRepository $ApprenantRepo)
    {
        $promo= $this->repoPromo->findOneBy(["id"=>$id_promo]);
            //  dd($promo);
         $brief= $this->repoBrief->findOneBy(["id"=>$id_brief]);
            // dd($brief);
            if(!$promo){
             return new JsonResponse("Cette promo n'existe pas", Response::HTTP_NOT_FOUND);
            }
            elseif (!$brief) {
                # code...
                return new JsonResponse("Cette brief n'existe pas", Response::HTTP_NOT_FOUND);
            }
            else{
                $BriefMaPromos=$promo->getBriefMaPromos();
                // dd($BriefMaPromo);
                foreach($BriefMaPromos as $BriefMaPromo){
                    
                }
            }
    }

    
    /**
    * @Route(
    * name="put_promo_brief",
    * path="formateurs/promo/{id_promo}/brief/{id_brief}",
    * methods={"PUT"}
    * )
    */
    Public function PutPromoBrief(int $id_promo, int $id_brief,Request $request, ApprenantRepository $ApprenantRepo)
    {
        $promo= $this->repoPromo->findOneBy(["id"=>$id_promo]);
        //  dd($promo);
         $brief= $this->repoBrief->findOneBy(["id"=>$id_brief]);
        // dd($brief);
        $datas = $request->getContent(); 
        $data = $this->serializer->decode($datas, "json");     
        // dd($data);
        
        $statut=isset($data["statut"]) ? $data["statut"]:null;
        $niveaux=isset($data["niveaux"]) ? $data["niveaux"]:null;
        // dd($niveaux);
        if(!$promo){
         return new JsonResponse("Cette promo n'existe pas", Response::HTTP_NOT_FOUND);
        }
        elseif (!$brief) {
            # code...
            return new JsonResponse("Cette brief n'existe pas", Response::HTTP_NOT_FOUND);
        }
        else{
            $BriefMaPromos=$brief->getBriefMaPromos();
            // dd($BriefMaPromo);
            foreach($BriefMaPromos as $BriefMaPromo){
                //  dd($BriefMaPromo->getPromo());
                if($BriefMaPromo->getPromo()==$promo){
                    $BriefTab = $this->serializer->denormalize($data, "App\Entity\Briefs");
                    // Archiver ou cloturer une brief
                    // if($statut){
                    //     //   dd($statut);
                    //     $brief->setStatut($statut);
                    //     $this->manager->persist($brief);
                    //     $this->manager->flush();
                    //     return new JsonResponse("Statut ".$statut." avec succés", Response::HTTP_OK, [], true);
                    // }
                     if($niveaux){
                    //       foreach ($niveaux as $niveau) {
                    //           dd($nivrau)[0];
                    //         # code...
                             AjoutNiveau();
                    //          $nveau_ok= $this->repoNiveau->findBy(array("id"=>$niveaux[0]));
                    //          dd($nveau[0]);
                    // //      }
                     }
                    
                }
            }
        }
         return new JsonResponse("ok", Response::HTTP_OK, [], true);
    }

    public function AjoutNiveau(){

         

         return dd($data['niveaux']);
    }
}



 