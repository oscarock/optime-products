<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Categories;
use App\Form\CategoryType;

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

    /**
     * @Route("/new-categories", name="new-categories")
    */
    public function new(EntityManagerInterface $em, Request $request,ValidatorInterface $validator)
    {
        $categories = new Categories();
        $form = $this->createForm(CategoryType::class, $categories);
        $form->handleRequest($request);
        $errors = $validator->validate($categories);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $categories->setCode($form->get('code')->getData());
            $categories->setName($form->get('name')->getData());
            $categories->setDescription($form->get('description')->getData());
            $categories->setActive($form->get('active')->getData());

            $em = $this->getDoctrine()->getManager();
            $em->persist($categories);
            $em->flush();

            $this->addFlash('success', 'Categoria Guardada correctamente.');

            return $this->redirect('/categories/');
        }

        return $this->render('categories/new.html.twig', array(
            'form' => $form->createView(),
            'errors' => $errors
        ));
    }

    /**
     * @Route("/edit/{id}", name="edit")
    */
    public function edit(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('App\Entity\Categories')->find($id);

        if (!$categories) {
            throw $this->createNotFoundException(
                'No se encontro el id'
            );
        }

        $form = $this->createForm(CategoryType::class, $categories);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em->flush();

            $this->addFlash('success', 'Categoria editada correctamente.');

            return $this->redirect('/categories/');
        }

        return $this->render('categories/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
