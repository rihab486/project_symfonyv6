<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Services\CartService;
use Symfony\Component\HttpFoundation\RequestStack;

class CartController extends AbstractController
{


    public function __construct(private CartService $cartService){

        $this->cartService= $cartService;
     }
    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    #[Route('/cart/add/{productId}/{count}', name: 'app_cart')]
    public function addToCart(string $productId ,$count=1): Response
    {   
       // $products= $this->$productId->findById();
        $this->cartService->addToCart($productId,$count);
        dd($this->cartService->getCart());
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
