<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Entity\Category;
use App\Form\SearchType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/nos-produits', name: 'app_products')]

    public function index(Request $request): Response
    {   
        $products = $this->entityManager->getRepository(Product::class)->findAll();
        $categories = $this->entityManager->getRepository(Category::class)->findAll();

        $search = new Search(); 

        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
            // dd($search);
            }
        return $this->render('product/index.html.twig', [
            'products'=> $products,
            'categories'=>$categories,
            'form'=> $form->CreateView()
        ]);
    }

    #[Route('/produit/{id}', name: 'app_product')]

    public function show($id): Response
    {   
        // dd($slug);
        $product = $this->entityManager->getRepository(Product::class)->findOneById($id);
        // dd($products);
        if(!$product){
            return $this->redirectToRoute('app_products');
        }
        return $this->render('product/show.html.twig', [
            'product'=> $product
        ]);
    }
}
