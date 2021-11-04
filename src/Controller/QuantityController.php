<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuantityController extends AbstractController
{
    /**
     * @Route("/quantity", name="quantity")
     */
    public function index(): Response
    {
        return $this->render('quantity/index.html.twig', [
            'controller_name' => 'QuantityController',
        ]);
    }
}
