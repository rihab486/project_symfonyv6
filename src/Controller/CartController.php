<?php

namespace App\Controller;

use App\Services\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    public function __construct(
        private CartService $cartService,
    ) {
        $this->cartService = $cartService;
    }

    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        $cart = $this->cartService->getCartDetails();
        $cart_json =json_encode($cart);
        //return $this->json($cart_json);
        
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'cart' => $cart,
            'cart_json'=> $cart_json,
        ]);
    }

    #[Route('/cart/add/{productId}/{count}', name: 'app_add_to_cart')]
    public function addToCart(string $productId, $count = 1): Response
    {
        $this->cartService->addToCart($productId,$count);
        $cart = $this->cartService->getCartDetails();
        //dd($this->cartService->getCartDetails());
       // return $this->redirectToRoute("app_cart");
        return $this->json($cart);
        
    }
    #[Route('/cart/remove/{productId}/{count}', name: 'app_remove_to_cart')]
    public function removeToCart(string $productId, $count = 1): Response
    {
        $this->cartService->removeToCart($productId,$count);
        $cart = $this->cartService->getCartDetails();
       // return $this->redirectToRoute("app_cart");
       return $this->json($cart);
        
    }
    #[Route('/cart/get', name: 'app_get_cart')]
    public function getCart(): Response
    {
        
        $cart = $this->cartService->getCartDetails();
        return $this->json($cart);
        
    }
}
