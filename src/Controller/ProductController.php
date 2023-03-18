<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    #[Route('/nos-produits', name: 'app_product')]
    public function index(): Response
    {
        $products = $this->productRepository->findAll();
        //dd($products);
        return $this->render('product/index.html.twig',[
            'products' => $products
        ]);
    }
    #[Route('/produit/{slug}', name: 'one_product')]
    public function anotherPage($slug): Response
    {
        $product = $this->productRepository->findOneBySlug($slug);
        if(!$product){
            return $this->redirectToRoute('app_product');
        }
        return $this->render('product/anotherPage.html.twig',[
            'product' => $product
        ]);
    }
}
