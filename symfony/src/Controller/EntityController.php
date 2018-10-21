<?php

namespace App\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
Use App\Entity\Product;

class EntityController extends Controller
{
    // afin de respecter la spécification MVC du test une page d'accueil permettra de faire une vue, comme le reste des demandes est du webservice => json
    public function index()
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        if (!$products) {
            throw $this->createNotFoundException(
                'No product found '
            );
        }
         return $this->render('entities.html.twig',
             array('products' => $products)
         );
    }
}