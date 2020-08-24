<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Promo;
use App\Entity\Groupe;
use App\Entity\Apprenant;
use App\Repository\ProfilRepository;
use App\Controller\PromotionController;
use App\Repository\ApprenantRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PromotionController extends AbstractController
{
/**
* @Route(
*     path="/api/admin/promos",
*     name="addPromo",
*     methods={"POST"},
*     defaults={
*          "__controller"="App\Controller\PromotionController::addPromo",
*          "__api_resource_class"=Promo::class,
*          "__api_collection_operation_name"="addPromo"
*     }
* )
*/
public function addPromo(Request $request, UserPasswordEncoderInterface $encoder,ApprenantRepository $repoapprenant, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager,\Swift_Mailer $mailer, ProfilRepository $repoProfil)
{
    $groupe=new Groupe();
    $groupe->setType('Principal');
    $groupe->setStatut('actif');
    $groupe->setNom('Omar');
    //$groupe->setDateCreation(\DateTime);
$promo=$serializer->denormalize($request->request->all(),Promo::class);

$doc = $request->files->get("document");
$file= IOFactory::identify($doc);
$reader= IOFactory::createReader($file);
$spreadsheet=$reader->load($doc);
$fichierexcel= $spreadsheet->getActivesheet()->toArray();

//$apprenants=[];
foreach ($fichierexcel as $email){
    $apprenant=$repoapprenant->findOneBy(['email'=>$email]);
    if(!empty($apprenant)){
        $groupe->addApprenant($apprenant);
        $message=(new\Swift_Message)
            ->setSubject('SONATEL ACADEMY')
            ->setFrom('fayeomzolive@gmail.com')
            ->setTo($email)
            ->setBody("Bonsoir Cher(e) candidat(e) à la sonatel Academy. \n Après les différentes étapes de sélection que tu as passé avec brio, nous t’informons que ta candidature a été retenue pour intégrer la promotion cette anné de la première école de codage gratuite du Sénégal.\n Rendez-vous sur www.sonatelacademy.sn et voici vos informations de connexion :\n Username: ".$user->getEmail()." \n Password : ".$password." ");
        $mailer->send($message);
    }
}
$promo->addGroupe($groupe);

//$password="password";
/*
for ($i=1; $i<count($fichierexcel); $i++){


    $apprenant = new Apprenant();
    $apprenant->setEmail($fichierexcel[$i][0])
        ->setPassword($encoder->encodePassword($apprenant,$password))
        ->setFirstName($fichierexcel[$i][1])
        ->setLastName($fichierexcel[$i][2])
        ->setAdresse($fichierexcel[$i][3])
        ->setStatut($fichierexcel[$i][4]);
$apprenant->addGroupe($groupe);
$groupe->setArchived(0)
    ->setType("Groupe principal")
    ->setDateCreation(new \DateTime);
$groupe->addApprenant($apprenant);
$user=new User();
$user->setEmail($fichierexcel[$i][0])
    ->setPassword($encoder->encodePassword($user,$password))
    ->setFirstName($fichierexcel[$i][1])
     ->setLastName($fichierexcel[$i][2])
;
$user->setProfil($repoProfil->findOneByLibelle("Apprenant"));

$manager->persist($user);
$manager->persist($apprenant);

}*/


//$promo->addGroupe($groupe);
$errors = $validator->validate($promo);
if (count($errors)) {
$errors = $serializer->serialize($errors, "json");
return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
}
$manager->persist($groupe);
$manager->persist($promo);
$manager->flush();
return $this->json($serializer->normalize($promo), Response::HTTP_CREATED);
}
}