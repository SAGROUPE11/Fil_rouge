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

class AddBriefController extends AbstractController
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
     * name="add_brief",
     * path="formateurs/briefs",
     * methods={"POST"}
     * )
     */

    public function addBrief(TagRepository $repoTag, Request $request, GroupeRepository $repoGroupe,BriefGroupeRepository $repoBriefGroupe, RessourceRepository $repoRessource)
    {  
        $brief = new Briefs();
        $TabJson = $request->getContent();
        $briefTab = $this->serializer->decode($TabJson, "json");     
        $IdReferenciel = $briefTab['referenciel']; 
        $Idformateur = $briefTab['formateur']; 
        $IdbriefsGroupe = $briefTab['brief_groupe']; 
        $groupes = $briefTab['brief_groupe']["groupe"];  
        $niveaux = isset($briefTab['niveaux']) ? $briefTab['niveaux'] : [];
        // dd($niveaux);
        $livrableAttendus = isset($briefTab['livrableAttenduses']) ? $briefTab['livrableAttenduses'] : [];
        // dd($livrableAttenduses);
        $tags = isset($briefTab['tags']) ? $briefTab['tags'] : []; 
        // dd($tags);
        $ressources = isset($briefTab['ressource']) ? $briefTab['ressource'] : [];
    //   dd($ressources);
        // dd($ressources);
        $briefTab["formateur"]=null;
        $briefTab["referenciel"]=null;
        $briefTab["niveaux"]=[];
        $briefTab["livrableAttenduses"]=[];
        $briefTab["tags"]=[];
        $briefTab["ressource"]=[];
        $briefTab["brief_groupe"]= null;

        $TabJson = $this->serializer->denormalize($briefTab, "App\Entity\Briefs");

        $referenciel = $this->repoReferentiel->findOneBy(["id"=>$IdReferenciel]);
        if (!$referenciel) {
            return  new JsonResponse("Le referenciel ne peut etre vide",Response::HTTP_NOT_FOUND);
        }
        $formateur = $this->repoFormateur->findOneBy(["id"=>$Idformateur]); 
        // dd($formateur);
            if (!$formateur) {
                return  new JsonResponse("L'identifiant du formateur n'existe pas",Response::HTTP_NOT_FOUND);
            }
        
            $TabJson->setFormateurs($formateur)
                    ->setReferenciel($referenciel);

            if (!$niveaux) {
                return new JsonResponse("Veuillez ajouter au moins une niveau",Response::HTTP_NOT_FOUND);
            }
            foreach ($niveaux as $niveau) {
                $BriefNiveau = $this->repoNiveau->findOneBy(["id"=>$niveau]);
                //   dd($BriefNiveau);
                if (!$BriefNiveau) {
                    return  new JsonResponse("Ce niveau n'existe pas",Response::HTTP_NOT_FOUND);
                }
                 $TabJson->addNiveau($BriefNiveau);
            }

            if (!$livrableAttendus) {
                return  new JsonResponse("Veuillez ajouter au moins une livrable attendu",Response::HTTP_NOT_FOUND);
        }
        // dd($livrableAttendus);
        foreach ($livrableAttendus as $livrableAttendu) {
            $livrable =   $this->repoLivrable->findOneBy(["id"=>$livrableAttendu]);
            if (!$livrable) {
                return  new JsonResponse("Ce livrable attendus n'existe pas",Response::HTTP_NOT_FOUND);
            }
            // dd($livrable);
            $TabJson->addLivrablesAttendus($livrable);
        }
        if(!$tags) {
            return  new JsonResponse("Veuillez ajouter au moins un tag",Response::HTTP_NOT_FOUND);
        }
        foreach ($tags as $tag) {
            $Brieftags = $repoTag->findOneBy(["id"=>$tag]);
            if (!$Brieftags) {
                return  new JsonResponse("Ce tag n'existe pas",Response::HTTP_NOT_FOUND);
            }
            $TabJson->addTag($Brieftags);
        }
        if (!$ressources) { 
            return  new JsonResponse("Veuillez ajouter au moins une Ressource",Response::HTTP_NOT_FOUND);
        }
        foreach ($ressources as $ressource) { 
            $Briefressource = $repoRessource->findOneBy(["id"=>$ressource]);  
         
            if (!$Briefressource) {
                return  new JsonResponse("Cette ressource n'existe pas",Response::HTTP_NOT_FOUND);
            }
            $TabJson->setRessource($Briefressource);
        }
        $IdGroupe = $this->groupeRepo->findOneBy(["id"=>$IdbriefsGroupe]);
        $TabJson->getBriefGroupes($IdGroupe);
        if ($groupes) {         
            foreach ($groupes as $groupe) {
                $search=$this->groupeRepo->findOneBy(["id"=>$groupe['id']]);
                // dd($search);
                if ($search) {
                    $promo = $grpeRepo->findOneBy(["id"=>$groupe['id']])->getPromos();
                    $BMP = new BriefMaPromo();
                    $BMP->setPromo($promo);
                    $BMP->setBriefs($TabJson);
                    $this->manager->persist($BMP);
                }
            }
            
        }
        $this->manager->persist($TabJson);
        $this->manager->flush();
        return new JsonResponse("Brief ajouter avec succés", Response::HTTP_OK, [], true);
    }
}