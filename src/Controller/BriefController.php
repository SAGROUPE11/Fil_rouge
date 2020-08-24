<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Tags;
use App\Entity\Promo;
use App\Entity\Briefs;
use App\Entity\Formateur;
use App\Entity\BriefMaPromo;
use App\Controller\BriefController;
use App\Repository\BriefRepository;
use App\Repository\PromoRepository;
use App\Repository\GroupeRepository;
use App\Repository\FormateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BriefController extends AbstractController
{
    private $manager,
            $serializer,
            $validator,
            $repoPromo,
            $repoFormateur,
            $groupeRepo,
            $encoder,
            $repoBrief;
    public function __construct(UserPasswordEncoderInterface $encoder,PromoRepository $repoPromo, 
    FormateurRepository $repoFormateur,BriefRepository $repoBrief, 
    ValidatorInterface $validator,EntityManagerInterface $manager,
    SerializerInterface $serializer,GroupeRepository $groupeRepo)
    {
        $this->serializer = $serializer;
        $this->repoBrief = $repoBrief;
        $this->manager = $manager;
        $this->validator = $validator;
        $this->groupeRepo = $groupeRepo;
        $this->repoPromo=$repoPromo;
        $this->repoFormateur=$repoFormateur;
        $this->encoder=$encoder;
    }
    
     /**
     * @Route(
     * name="show_FormateurPromoGroupesBriefById",
     * path="/formateurs/{id_formateur}/promo/{id_promo}/briefs/{id_brief}",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\BriefController::getFormateurPromoBrief",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="get_FormateurPromoGroupesBriefById"
     * }
     * )
     */
    
    Public function getFormateurPromoBrief(int $id_formateur, int $id_promo, int $id_brief)
    {
        
        $formateur= $this->repoFormateur->findOneBy(["id"=>$id_formateur]);
        // dd($formateur);
        $promo= $this->repoPromo->findOneBy(["id"=>$id_promo]);
        // dd($promo);
        $brief= $this->repoBrief->findOneBy(["id"=>$id_brief]);
        // dd($brief);
        // dd($brief->getPromo());
        //  dd($briefMapromo->getPromo());
            foreach ($promo as $value) {
                # code...
                if ($brief->getPromo()!=$value) {
                   # code...
                    return new JsonResponse("Ressource inexistante", Response::HTTP_FORBIDDEN);
                } 
            }
            $result = $this->serializer->serialize($promo, 'json',["groups"=>["brief_route7:read"]]);
            return new JsonResponse($result, Response::HTTP_OK, [], true);
    }

     /**
     * @Route(
     * name="add_formateur_brief",
     * path="formateurs/briefs/{id}",
     * methods={"POST"},
     * defaults={
     * "_controller"="\App\Controller\BriefController::addFormateurBrief",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="post_formateur_brief"
     * }
     * )
     */

    public function addFormateurBrief(Request $request, int $id)
    {   
        $findId= $this->repoBrief->findOneBy([
            "id"=>$id]);
            //dd($findId);
            // dd($findId->getTitre());
            // $tags= new Tag();
        if($findId){
            $brief= new Briefs();
        $brief->setTitre($findId->getTitre())
                 ->setEnonce($findId->getEnonce())
                 ->setContexte($findId->getContexte())
                 ->setCreatedAt($findId->getCreatedAt())
                 ->setDateEcheance($findId->getDateEcheance())
                 ->setEtat($findId->getEtat())
                 ->setFormateurs($findId->getFormateurs())
                 ->addTag($findId->getTags())
                ;
            // dd($briefs);
            
            $this->manager->persist($brief);
            $this->manager->flush();
                      
        return new JsonResponse("Vous avez dupliquer une brief avec succes",Response::HTTP_CREATED,[],true);
        }
        
            return new JsonResponse("Cette ressource n'existe pas",Response::HTTP_NOT_FOUND);
      
    }
    
     /**
     * @Route(
     * name="add_brief",
     * path="formateurs/briefs",
     * methods={"POST"},
     * defaults={
     * "_controller"="\App\Controller\BriefController::addBrief",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="post_brief"
     * }
     * )
     */

    public function addBrief(Request $request, int $id)
    {          
        $briefs = $request->getContent();
        // dd($briefs);
        $brief = $this->serializer->deserialize($briefs, Briefs::class, 'json');
        $errors = $this->validator->validate($brief);
        if (count($errors) > 0) {
            $errorsString =$this->serializer->serialize($errors,"json");
            return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
        }
        // $entityManager = $this->getDoctrine()->getManager();
        $this->manager->persist($brief);
        $this->manager->flush();
        return new JsonResponse("vous avez ajouter une brief avec succes",Response::HTTP_CREATED,[],true);
   
   }

     /**
     * @Route(
     * name="add_formateur_brief",
     * path="formateurs/briefs/{id}",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\BriefController::addApprenantBrief",
     * "_api_resource_class"=Promo::class,
     * "_api_collection_operation_name"="post_formateur_brief"
     * }
     * )
     */

    // public function addApprenantBrief(Request $request, int $id)
    // {   
    //     $brief= new Briefs();
    //     $findId= $this->repoBrief->findOneBy([
    //         "id"=>$id]);
    //         //dd($findId);
    //         // dd($findId->getTitre());
    //         // $tags= new Tag();
    //         $tag=$findId->getTags();
    //         // dd($tag[2]);
    //     $brief->setTitre($findId->getTitre())
    //              ->setEnonce($findId->getEnonce())
    //              ->setContexte($findId->getContexte())
    //              ->setCreatedAt($findId->getCreatedAt())
    //              ->setDateEcheance($findId->getDateEcheance())
    //              ->setEtat($findId->getEtat())
    //              ->setFormateurs($findId->getFormateurs())
    //              ->addTag($findId->getTags());
    //              dd($brief);       

        // $briefs = $request->getContent();
        // // dd($briefs);
        // $brief = $this->serializer->deserialize($briefs, Briefs::class, 'json');
        // $errors = $validator->validate($user);
        // if (count($errors) > 0) {
        //     $errorsString =$serializer->serialize($errors,"json");
        //     return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
        // }
        // $entityManager = $this->getDoctrine()->getManager();
        // $entityManager->persist($user);
        // $entityManager->flush();
        // return new JsonResponse("vous avez ajouter un user succes",Response::HTTP_CREATED,[],true);
   
    // }
}
