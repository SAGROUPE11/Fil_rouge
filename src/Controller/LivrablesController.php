<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LivrablesController extends AbstractController
{
    /**
     * @Route("/livrables", name="livrables")
     */
    public function index()
    {
        return $this->render('livrables/index.html.twig', [
            'controller_name' => 'LivrablesController',
        ]);
    }
}
