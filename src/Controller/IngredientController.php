<?php

namespace App\Controller;

use App\Form\IngredientFormType;
use App\Entity\Ingredient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class IngredientController extends AbstractController
{
    /**
     * @Route("/ingredient", name="form_ingredient")
     */
    public function addIngredient(Request $request): Response
    {
    	$ingredient = new Ingredient();
    	$form = $this->createForm(IngredientFormType::class, $ingredient);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($ingredient);
        $entityManager->flush();
    }
        return $this->render("ingredient/ingredient-form.html.twig", [
            "form_title" => "Add ingredient",
            "form_ingredient" => $form->createView(),
        ]);
    }
	/**
     * @Route("/ingredients", name="ingredients")
     */
	public function ingredients()
	{
    	$ingredients = $this->getDoctrine()->getRepository(Ingredient::class)->findAll();
    	return $this->render('ingredient/ingredients.html.twig', [
	       	 "ingredients" => $ingredients,
    	]);
	}


	/**
     * @Route("/ingredient/{id}", name="ingredient")
     */
	public function ingredient(int $id): Response
	{
	    $ingredient = $this->getDoctrine()->getRepository(Ingredient::class)->find($id);
	    return $this->render("ingredient/ingredient.html.twig", [
	        "ingredient" => $ingredient,
	    ]);
	}

	/**
     * @Route("/modify-ingredient/{id}", name="modify_ingredient")
     */
	public function modifyIngredient(Request $request, int $id): Response
	{
	    $entityManager = $this->getDoctrine()->getManager();
	    $ingredient = $entityManager->getRepository(Ingredient::class)->find($id);
	    $form = $this->createForm(IngredientFormType::class, $ingredient);
	    $form->handleRequest($request);
	    if($form->isSubmitted() && $form->isValid())
	    {
	        $entityManager->flush();
	    }
	    return $this->render("ingredient/ingredient-form.html.twig", [
	        "form_title" => "Edit ingredient",
	        "form_ingredient" => $form->createView(),
	    ]);
	}


	/**
     * @Route("/delete-ingredient/{id}", name="delete_ingredient")
     */
	public function deleteIngredient(int $id): Response
	{
	    $entityManager = $this->getDoctrine()->getManager();
	    $ingredient = $entityManager->getRepository(Ingredient::class)->find($id);
	    $entityManager->remove($ingredient);
	    $entityManager->flush();
	    return $this->redirectToRoute("ingredients");
	}

}
