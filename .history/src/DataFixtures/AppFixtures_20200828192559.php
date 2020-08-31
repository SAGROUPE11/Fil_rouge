<?php

namespace App\DataFixtures;

use App\Entity\ApprenantLivrablePartielle;
use App\Entity\Commentaire;
use App\Entity\FilDeDiscution;
use App\Entity\LivrablePartiel;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Promo;
use App\Entity\Groupe;
use App\Entity\Niveau;
use App\Entity\Profil;
use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Entity\Competences;
use App\Entity\Referenciel;
use App\Entity\ProfilSorties;
use App\Entity\GroupeCompetences;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function  __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder=$encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('fr_FR');
        $profilTab=['Admin','CM'];
        $tabDev=['html','php','javascript','mysql'];
        $tabGestion=['Anglais des affaires','Marketing','Community management'];
        $tabProfilSorti=['Dev Front End','Dev Back End','Community manager', 'Dev Full Stack', 'Integrateur','WebMaster', 'Administrateur BD'];
        $profil1 = new Profil();
                    $profil1->setLibelle("Apprenant");
                    $manager->persist($profil1);
        
                    $profil2 = new Profil();
                    $profil2->setLibelle("Formateur");
                    $manager->persist($profil2);
        for ($i=0; $i < 3 ; $i++) { 
            $groupe1 = new Groupe;
            $groupe1->setNom('Groupe'.($i+1))
                    ->setDateCreation(new \DateTime())
                    ->setStatut('Statut'.($i+1))
                    ->setType('Type'.($i+1))
                    ;
                    $manager->persist($groupe1);
        }
        for ($u=0; $u<4; $u++) {
            $a = new Apprenant();
            $hash = $this->encoder->encodePassword($a, 'password');
            $a->setFirstName($faker->firstName())
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setAdresse($faker->address)
                ->setStatut($faker->randomElement(["actif","renvoyé","abandonné","décédé","suspendu"]))
                ->setPassword($hash)
                ->setAvatar($faker->image('public/img/',400,300, false))
                ->setProfil($profil1)
                ->addGroupe($groupe1);
            $manager->persist($a);
        }

        for ($i=0; $i <count($tabProfilSorti) ; $i++) { 
            # code...
            $profilSortie= new ProfilSorties();
            $profilSortie->setLibelle($tabProfilSorti[$i])
             ->addApprenant($a);
             $manager->persist($profilSortie);
        }
        
        for ($p=0; $p<2; $p++){
            $profil= new Profil();
            $profil->setLibelle($profilTab[$p]);
            $manager->persist($profil);
            for ($u=0; $u<4; $u++) {
                $user = new User();
                $hash = $this->encoder->encodePassword($user, 'password');
                $user->setFirstName($faker->firstName())
                    ->setLastName($faker->lastName)
                    ->setEmail($faker->email)
                    ->setPassword($hash)
                    ->setProfil($profil);

                $manager->persist($user);
            }
        }

                $groupe= new GroupeCompetences();
                $groupe->setLibelle('Developpement Web')
                    ->setDescriptif('description developpement web');

                $manager->persist($groupe);
        for ($c=0; $c<count($tabDev); $c++){

            $comp= new Competences();
            $comp->setLibelle($tabDev[$c])
                ->addGroupeCompetence($groupe);

            $manager->persist($comp);

        }

                $groupe2= new GroupeCompetences();
                $groupe2->setLibelle('Gestion de Projet')
                    ->setDescriptif('description gestion de projet');
                $manager->persist($groupe2);

        for ($c=0; $c<count($tabGestion); $c++){
            $comp1= new Competences();
            $comp1->setLibelle($tabGestion[$c])
                ->addGroupeCompetence($groupe2);
            $manager->persist($comp1);


        }


            $referentiel= new Referenciel();
            $referentiel
                ->setLibelle('Referentiel DevWeb')
                ->setPresentation('referentiel devWeb')
                ->setProgramme('algo, programmation web, mobile')
                ->setCriteresAdmission('avoir moins de 35 ans')
                ->setCriteresEvaluation('test logique, base de donnee, math, programmation')
                ->addGroupeCompetence($groupe)
                ;
            $manager->persist($referentiel);

         $referentiel1= new Referenciel();
            $referentiel1
                ->setLibelle('Referentiel Marketing Digital')
                ->setPresentation('referentiel marketing')
                ->setProgramme('anglais, marketing , community management')
                ->setCriteresAdmission('avoir moins de 35 ans')
                ->setCriteresEvaluation('test anglais, , francais')
                ->addGroupeCompetence($groupe2)
                ;
            $manager->persist($referentiel1);

            $promos = new Promo();
            $promos->setLangue('Français')
                    ->setTitre('Promos 3')
                    ->setDescription('Description Promos 3')
                    ->setLieu('Orange Digital Center')
                    ->setReference('Web Designer')
                    ->setDateDebut($faker->dateTime())
                    ->setDateFinProvisoire($faker->dateTime())
                    ->setFabrique('Projet Jeux')
                    ->setDateFinReelle($faker->dateTime())
                    ->setEtat('Actif')
                    ->addGroupe($groupe1)
                    ->addReferenciel($referentiel)
                    ;
                $manager->persist($promos);
    
                $promo = new Promo();
                $promo->setLangue('Anglais')
                    ->setTitre('Promos 2')
                    ->setDescription('Description Promos 2')
                    ->setLieu('Orange Digital Center')
                    ->setReference('Data artisan')
                    ->setDateDebut($faker->dateTime())
                    ->setDateFinProvisoire($faker->dateTime())
                    ->setFabrique('Projet fil Rouge')
                    ->setDateFinReelle($faker->dateTime())
                    ->setEtat('Actif')
                    ->addGroupe($groupe1)
                    ->addReferenciel($referentiel1)
                    ;
                $manager->persist($promo);


        for ($u=0; $u<4; $u++) {
            $formateur = new Formateur();
            $hash = $this->encoder->encodePassword($formateur, 'password');
            $formateur->addPromo($promos)
            ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setPassword($hash)
                ->setTelephone("770891234")
                ->setProfil($profil2)
                ->addGroupe($groupe1)
                ;

            $manager->persist($formateur);
        }
        for ($p=0; $p<2; $p++){
            $applivpartielle= new ApprenantLivrablePartielle();
            $applivpartielle->setEtat("etat")
                ->setDelai($faker->dateTime());
            $manager->persist($applivpartielle);

            $livrablepartiel=new LivrablePartiel();
            $livrablepartiel->setLibelle("livrable1")
                ->setLibelle("modelisation")
                ->setDelai($faker->dateTime())
                ->setType("apprenant")
                ->setDescription("admin")
                ->setNombreRendu(3)
                ->addApprenantLivrablePartielle($applivpartielle);
            $manager->persist($livrablepartiel);

            $commentaire= new Commentaire();
            $commentaire->setDescription("apprenant")
                ->setDateCreation($faker->dateTime());
            $manager->persist($commentaire);

            $filDiscution= new FilDeDiscution();
            $filDiscution->setLibelle("formateur")
                ->addCommentaire($commentaire);
            $manager->persist($filDiscution);

        }
            $niveau = new Niveau();

            $niveau->setLibelle('Niveau1');

            $niveau->setCritereEvaluation("Critere d'evaluation");

            $niveau->setGroupeAction("Groupe d'action");

            $niveau->setCompetence($comp1);

            $manager->persist($niveau);

            $niveau = new Niveau();

            $niveau->setLibelle('Niveau2');

            $niveau->setCritereEvaluation("Critere d'evaluation");

            $niveau->setGroupeAction("Groupe d'action");

            $niveau->setCompetence($comp1);

            $manager->persist($niveau);

            $niveau = new Niveau();

            $niveau->setLibelle('Niveau3');

            $niveau->setCritereEvaluation("Critere d'evaluation");

            $niveau->setGroupeAction("Groupe d'action");

            $niveau->setCompetence($comp1);

            $manager->persist($niveau);
                       
            $niveau = new Niveau();

            $niveau->setLibelle('Niveau1');

            $niveau->setCritereEvaluation("Critere d'evaluation");

            $niveau->setGroupeAction("Groupe d'action");

            $niveau->setCompetence($comp);

            $manager->persist($niveau);

            $niveau = new Niveau();

            $niveau->setLibelle('Niveau2');

            $niveau->setCritereEvaluation("Critere d'evaluation");

            $niveau->setGroupeAction("Groupe d'action");

            $niveau->setCompetence($comp);

            $manager->persist($niveau);

            $niveau = new Niveau();

            $niveau->setLibelle('Niveau3');

            $niveau->setCritereEvaluation("Critere d'evaluation");

            $niveau->setGroupeAction("Groupe d'action");

            $niveau->setCompetence($comp);

            $manager->persist($niveau);
                       


        $manager->flush();
    }
}