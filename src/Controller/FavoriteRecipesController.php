<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteRecipesController extends AbstractController
{
    /**
     * @Route("/favorite/recipes", name="favorite_recipes")
     */
    public function index(): Response
    {
        return $this->render('favorite_recipes/favorite-recipes-form.html.twig', [
            'controller_name' => 'FavoriteRecipesController',
        ]);
    }
}
