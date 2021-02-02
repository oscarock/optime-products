<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository('App\Entity\Categories')
            ->findAll();

            return $this->render(
            'categories/index.html.twig',
            array('categories' => $categories)
        );
    }
}
