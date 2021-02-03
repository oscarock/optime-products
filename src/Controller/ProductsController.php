<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Categories;
use App\Entity\Products;
use App\Form\ProductType;

class ProductsController extends AbstractController
{
    /**
     * @Route("/products", name="products")
     */
    public function index(): Response
    {
			$products = $this->getDoctrine()
			->getRepository('App\Entity\Products')
			->findAll();

			return $this->render(
				'products/index.html.twig',
				array('products' => $products)
			);
    }

    /**
     * @Route("/new-products", name="new-products")
    */
    public function new(EntityManagerInterface $em, Request $request,ValidatorInterface $validator)
    {
        $products = new Products();
        $form = $this->createForm(ProductType::class, $products);
        $form->handleRequest($request);
        $errors = $validator->validate($products);

        if ($form->isSubmitted() && $form->isValid()) {
					$data = $form->getData();
					$products->setCode($form->get('code')->getData());
					$products->setName($form->get('name')->getData());
					$products->setDescription($form->get('description')->getData());
					$products->setMark($form->get('mark')->getData());
					$products->setPrice($form->get('price')->getData());
					$products->setCategory($form->get('category')->getData());
					$em = $this->getDoctrine()->getManager();
					$em->persist($products);
					$em->flush();

					$this->addFlash('success', 'Producto Guardado correctamente.');

					return $this->redirect('/products/');
        }

        return $this->render('products/new.html.twig', array(
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
			$products = $em->getRepository('App\Entity\Products')->find($id);

			if (!$products) {
					throw $this->createNotFoundException(
							'No se encontro el id'
					);
			}

			$form = $this->createForm(ProductType::class, $products);

			$form->handleRequest($request);

			if ($form->isSubmitted() && $form->isValid()) {
					$data = $form->getData();
					$products->setCode($form->get('code')->getData());
					$products->setName($form->get('name')->getData());
					$products->setDescription($form->get('description')->getData());
					$products->setMark($form->get('mark')->getData());
					$products->setPrice($form->get('price')->getData());
					$products->setCategory($form->get('category')->getData());
					$em = $this->getDoctrine()->getManager();
					$em->persist($products);
					$em->flush();

					$this->addFlash('success', 'Producto editado correctamente.');

					return $this->redirect('/products/');
			}

			return $this->render('products/edit.html.twig', array(
				'form' => $form->createView(),
			));
		}

		/**
     * @Route("/delete/{id}", name="delete")
    */
    public function delete(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('App\Entity\Products')->find($id);

        if (!$products) {
            throw $this->createNotFoundException(
							'No se encontro el id'
            );
				}

				$em->remove($products);
				$em->flush();

				$this->addFlash('danger', 'Producto Eliminado correctamente.');
				return $this->redirect('/products/');
    }
}
