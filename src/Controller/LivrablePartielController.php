<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LivrablePartielController extends AbstractController
{
    /**
     * @Route("/livrable/partiel", name="livrable_partiel")
     */
    public function index()
    {
        return $this->render('livrable_partiel/index.html.twig', [
            'controller_name' => 'LivrablePartielController',
        ]);
    }
}
