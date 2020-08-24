<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ReferencielController extends AbstractController
{
    /**
     * @Route("/referenciel", name="referenciel")
     */
    public function index()
    {
        return $this->render('referenciel/index.html.twig', [
            'controller_name' => 'ReferencielController',
        ]);
    }
}
