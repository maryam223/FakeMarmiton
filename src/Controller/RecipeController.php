<?php

namespace App\Controller;

use App\Form\RecipeFormType;
use App\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class RecipeController extends AbstractController
{
    /**
     * @Route("/add-recipe", name="add_recipe")
     */
    public function addRecipe(Request $request): Response
    {
		$recipe = new Recipe();
        $form = $this->createForm(RecipeFormType::class, $recipe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
	        $entityManager->persist($recipe);
	        $entityManager->flush();
        }        

        return $this->render("recipe/recipe-form.html.twig", [
            "form_title" => "Add recipe",
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/recipes", name="recipes")
     */
    public function recipes()
    {
		$recipes = $this->getDoctrine()->getRepository(Recipe::class)->findAll();
        
        return $this->render("recipe/recipes.html.twig", [
            "recipes" => $recipes,
        ]);
    }

    /**
     * @Route("/recipe/{id}", name="recipe")
     */
    public function recipe(int $id): Response
    {
		$recipe = $this->getDoctrine()->getRepository(Recipe::class)->find($id);
       
        return $this->render("recipe/recipe.html.twig", [
            "recipe" => $recipe,
        ]);
    }

    /**
     * @Route("/modify-recipe/{id}", name="modify_recipe")
     */
    public function modifyRecipe(Request $request, int $id): Response
	{
	    $entityManager = $this->getDoctrine()->getManager();
	    $recipe = $entityManager->getRepository(Recipe::class)->find($id);
	    $form = $this->createForm(RecipeFormType::class, $recipe);
	    $form->handleRequest($request);
	    if($form->isSubmitted() && $form->isValid())
	    {
	        $entityManager->flush();
	    }
	    return $this->render("recipe/recipe-form.html.twig", [
	        "form_title" => "Edit recipe",
	        "form" => $form->createView(),
	    ]);
	}

	/**
     * @Route("/delete-recipe/{id}", name="delete_recipe")
     */
	public function deleteRecipe(int $id): Response
	{
	    $entityManager = $this->getDoctrine()->getManager();
	    $recipe = $entityManager->getRepository(Recipe::class)->find($id);
	    $entityManager->remove($recipe);
	    $entityManager->flush();
	    return $this->redirectToRoute("recipes");
	}
}
