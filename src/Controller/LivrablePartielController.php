<?php

namespace App\Controller;


use App\Entity\ApprenantLivrablePartielle;
use App\Entity\Commentaire;
use App\Entity\Apprenant;
use App\Entity\FilDeDiscution;
use App\Entity\Formateur;
use App\Entity\LivrablePartiel;
use App\Entity\BriefMaPromo;
use App\Entity\Niveau;
use App\Entity\NiveauLivrablePartielle;
use App\Repository\BriefMaPromoRepository;
use App\Repository\CompetenceRepository;
use App\Repository\CompetencesValidesRepository;
use App\Repository\FormateurRepository;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ApprenantLivrablePartielleRepository;
use App\Repository\LivrablePartielRepository;
use App\Repository\PromoRepository;
use App\Repository\ReferencielRepository;
use App\Repository\ApprenantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManager;

class LivrablePartielController extends AbstractController
{
    /**
     * @Route(
     * name="show_commentaire_formateur",
     * path="/api/formateurs/livrablepartiels/{id_livr}/commentaires",
     * methods={"GET"},
     * defaults={
     * "_controller"="\App\Controller\LivrablePartielController::ShowCommentaire",
     * "_api_resource_class"=LivrablePartiel::class,
     * "_api_collection_operation_name"="get_commentaire_formateur"
     * }
     * )
     */
    public function ShowCommentaire(SerializerInterface $serializer, LivrablePartielRepository $livrablePartielRepository, int $id_livr)
    {
        $livrablePartiel = $livrablePartielRepository->find($id_livr);
        if (empty($livrablePartiel)) {
            return new JsonResponse("Veuillez ajouter un livrable partielle existant.", Response::HTTP_NOT_FOUND, [], true);
        }

        $commentaires = [];
        foreach ($livrablePartiel->getApprenantLivrablePartielle() as $value) {
            foreach ($value->getFilDeDiscution()->getCommentaires() as  $vale) {
                $commentaires[] = $vale;
            }
        }

        $commentairesJson = $serializer->serialize($commentaires, 'json', ["groups" => ["commentaire:read"]]);
        return new JsonResponse($commentairesJson, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/formateurs/promo/{id_promo}/referentiel/{id_ref}/competences", name="show_statistiques_competences", methods="GET")
     */

    public function Competence_Niveau(SerializerInterface $serializer,$id_promo,$id_ref, CompetencesValidesRepository $competencesValidesRepository)
    {
        $competencesValides = $competencesValidesRepository->findOneBy(
            [
                "promo" => $id_promo, "referenciel" => $id_ref
            ]
        );

        $apprenant= $competencesValides->getApprenant();

        $competences = $serializer->serialize($apprenant, 'json', ["groups" => ["competences:read"]]);
        return new JsonResponse($competences, Response::HTTP_OK, [], true);
    }


    /**
     * @Route("/api/formateurs/promo/{id_promo}/referentiel/{id_ref}/statistiques/competences", name="show_statistiques_competencesvalid", methods="GET")
     */
    public function CompetencesValides(ReferencielRepository $repo,SerializerInterface $serializer,PromoRepository $promosRepository,CompetencesValidesRepository $competencesValidesRepository,ReferencielRepository $referencielRepository, $id_promo,$id_ref)
    {

        $promo = $promosRepository->find($id_promo);
        $referentiel = $referencielRepository->find($id_ref);
        $tab = [];
        foreach ($referentiel->getGroupeCompetences() as $groupeCompetence) {
            foreach ($groupeCompetence->getCompetences() as $competence) {
                $niveau1 = 0; $niveau2 = 0;  $niveau3 = 0;

                foreach ($promo->getApprenant() as $apprenant) {
                    $competenceValide = $competencesValidesRepository->find($id_promo, $id_ref, $competence->getId(), $apprenant->getId());
                    if ($competenceValide) {
                        if ($competenceValide->getNiveau1()) {
                            $niveau1 += 1;
                        }
                        if ($competenceValide->getNiveau2()) {
                            $niveau1 += 1;
                        }
                        if ($competenceValide->getNiveau3()) {
                            $niveau3 += +1;
                        }
                    }
                }
                //$tab[] = ["competences"=>$competence,"niveau 1"=>$niveau1.' apprenant valide',"niveau 2"=>$niveau2.' apprenant valide',"niveau 3"=>$niveau3.' apprenant valide'];
            $tab[]=["id"=>$competence->getId(),"libCompetence"=>$competence->getLibelle(),"niveau1"=>$niveau1,"niveau2"=>$niveau2,"niveau3"=>$niveau3];
            }
        }
        // dd($tab);
        return $this->json($tab,200,[],["groups"=>"grp"]);

    }

    /**
     * @Route("/api/formateurs/livrablepartiels/{id_liv}/commentaires", name="post_commentaire_formateur", methods="POST")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param int $id_liv
     * @param LivrablePartielRepository $repoLivrablePartiels
     * @param FormateurRepository $formateurRepository
     * @param TokenStorageInterface $storage
     * @return JsonResponse
     * @throws \Exception
     */
        public function CommentaireFormateur(Request $request, EntityManagerInterface $em, int $id_liv, LivrablePartielRepository $repoLivrablePartiels, FormateurRepository $formateurRepository,TokenStorageInterface $storage)
    {

        $data= json_decode($request->getContent(),'true');
        $commentaire = new Commentaire();

        $commentaire->setDescription($data['description']);
        $commentaire->setDateCreation(new \DateTime());
        $formateur = $storage->getToken()->getUser();
        $commentaire->setFormateur($formateur);

        $livrablePartiel = $repoLivrablePartiels->find($id_liv);
        foreach ($livrablePartiel->getApprenantLivrablePartielle() as $value) {
            if ($value->getFilDeDiscution()){
                $value->getFilDeDiscution()->addCommentaire($commentaire);
            }
        }
        $em->persist($commentaire);
        $em->flush();
        return new JsonResponse("Commentaire ajouté avec succes", Response::HTTP_CREATED, [], true);
    }

    /**
     * @Route("/api/formateurs/promo/{id_promo}/brief/{id_brief}/livrablepartiels", name="post_livrable_partiel_formateurs")
     */
    public function ajouterLivrablePartiel(EntityManagerInterface $em,BriefMaPromoRepository $repo, Request $request,ApprenantRepository $apprenantRepository, NiveauRepository $niveauRepository, int $id_brief, int $id_promo,SerializerInterface $serializer){
        $data = json_decode($request->getContent(), true);
        //dd($data);
        $date = new \DateTime($data["delai"]);
        $briefpromo=$repo->findBy(["briefs"=>$id_brief,"Promo"=>$id_promo]);
        //dd($briefpromo);

        $livrablePartiel=new LivrablePartiel();
        $livrablePartiel->setLibelle($data['libelle'])
            ->setDescription($data['description'])
            ->setDelai($date)
            ->setType($data['type'])
            ->setNombreRendu(2)
            ->setArchived(true)
            ->setBriefPromo($briefpromo[0]);
        ;

        $apprenant_partiel=new ApprenantLivrablePartielle();
        //$apprenant=$serializer->denormalize($data['apprenant'],"App\Entity\Apprenant", true);
        $apprenant=$apprenantRepository->find($data["apprenant"]);
        //dd($apprenant);
        $apprenant_partiel->setApprenant($apprenant)
            ->setLivrablePartiel($livrablePartiel)
            ->setEtat(0)
        ;
        //dd($apprenant_partiel);

        $niveauLivrablePartiel=new NiveauLivrablePartielle();
        //$niveau=$serializer->denormalize($data['niveau'],"App\Entity\Niveau", true);
        $niveau=$niveauRepository->find($data["niveau"]);
        $niveauLivrablePartiel->setNiveau($niveau)
            ->setLivrablePartiel($livrablePartiel);

        $em->persist($livrablePartiel);
        $em->persist($apprenant_partiel);
        $em->persist($niveauLivrablePartiel);

        $em->flush();

        return new JsonResponse("Livrable partielle ajouté avec succes!",Response::HTTP_CREATED,[],true);


    }

    /**
     * @Route(
     *     name="livrable_partiel_remove",
     *     path="/api/formateurs/promo/{id_promo}/brief/{id_brief}/livrablepartiels/{id_livrable_partiel}",
     *     methods={"DELETE"},
     *     defaults={
     *          "__controller"="App\Controller\LivrablePartielController::deleteLivrablePartiel",
     *          "__api_resource_class"=LivrablePartiel::class,
     *          "__api_collection_operation_name"="remove_livrable_partiel"
     *     }
     * )
     */
    public function deletelivrablePartiel(int $id_livrable_partiel, EntityManagerInterface $em, LivrablePartielRepository $repo){
        $livrable_partiel=$repo->find($id_livrable_partiel);
        $livrable_partiel->setArchived(1);
        $em->persist($livrable_partiel);
        $em->flush();
        //dd($livrable_partiel);
        return new JsonResponse("Livrable Partielle a ete supprimé avec succes!",Response::HTTP_OK,[],true);
    }

    /**
     * @Route("/api/apprenants/{id_app}/promo/{id_promo}/referentiel/{id_ref}/statistiques/briefs", name="show_statistiques_apprenant_id", methods="GET")
     */
        public function getStatistiquesByApprenantId(ApprenantRepository $appRepo,$id_app,$id_promo,$id_ref,SerializerInterface $serializer){
        $apprenant = $appRepo->find($id_app);
        $groupes = $apprenant->getGroupe();
            $nbreAssigne=$nreValid=$nbreNonValid=0;
        foreach ($groupes as $groupe){
                if ($groupe->getPromo()->getId() == $id_promo){
                    $briefs = $groupe->getBriefGroupes();
                    foreach ($briefs as $brief){
                        $statut =strtolower($brief->getStatut());
                        if ($statut === "valide"){
                            $nreValid +=1;
                        }elseif ($statut ==="non valide"){
                            $nbreNonValid +=1;
                        }else{
                            $nbreAssigne +=1;
                        }
                    }
                }
            $tab [] =["Apprenant"=>$apprenant, "Valide"=>$nreValid, "Non Valide"=>$nbreNonValid,"Assigne"=>$nbreAssigne];
        }
        // dd($tab);
        return $this->json($tab,200,[],['groups'=>'brief_read']);
    }
    /**
     * @Route("/api/apprenant/livrablepartiels/{id}/commentaires", name="post_commentaire_apprenant",methods="POST")
     */
    public function ShowCommentaires(SerializerInterface $serializer, LivrablePartielRepository $livrablePartielRepository, int $id_livr)
    {
        $livrablePartiel = $livrablePartielRepository->find($id_livr);
        if (empty($livrablePartiel)) {
            return new JsonResponse("Veuillez ajouter un livrable partielle existant.", Response::HTTP_NOT_FOUND, [], true);
        }

        $commentaires = [];
        foreach ($livrablePartiel->getApprenantLivrablePartielle() as $value) {
            foreach ($value->getFilDeDiscution()->getCommentaires() as  $vale) {
                $commentaires[] = $vale;
            }
        }

        $commentairesJson = $serializer->serialize($commentaires, 'json', ["groups" => ["commentaire:read"]]);
        return new JsonResponse($commentairesJson, Response::HTTP_OK, [], true);
    }



    /**
     * @Route("/api/apprenant/{id_apprenant}/promo/{id_promo}/referentiel/{id_ref}/competences", name="show_competences_apprenant_id", methods="GET")
     */
    public function showCompetenceApprenant(SerializerInterface $serializer, int $id_apprenant, int $id_promo, int $id_ref, ApprenantRepository $repoApprenant, ReferencielRepository $repoReferentiel, PromoRepository $repoPromo)
    {
        $referentiel = $repoReferentiel->find($id_ref);
        if (empty($referentiel)){
            return new JsonResponse("Veuillez ajouter un referenciel ki existe", Response::HTTP_NOT_FOUND, [], true);
        }

        $promo = $repoPromo->find($id_promo);
        if (empty($promo) || !$referentiel->getPromos()) {
            return new JsonResponse("Cette promo n'existe pas dans ce referentiel.", Response::HTTP_NOT_FOUND, [], true);
        }
        $apprenant = $repoApprenant->find($id_apprenant);
        if (empty($apprenant) || !$promo->getApprenant()) {
            return new JsonResponse("Cet apprenant n'existe pas dans cette promo.", Response::HTTP_NOT_FOUND, [], true);
        }

        $apprenantJson = $serializer->serialize($apprenant, 'json', ["groups" => ["apprenant_competence:read"]]);
        return new JsonResponse($apprenantJson, Response::HTTP_OK, [], true);
    }

}
