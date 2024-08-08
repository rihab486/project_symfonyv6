<?php

namespace App\Controller;

use App\Entity\Carrier;
use App\Repository\CarrierRepository;
use App\Services\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
<<<<<<< HEAD
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;



class CartController extends AbstractController
{
    public function __construct(
        private CartService $cartService,
        private CarrierRepository $carrierRepository ,
    ) {
        $this->cartService = $cartService;
      
    }

=======
use App\Repository\ProductRepository;
use App\Services\CartService;
use Symfony\Component\HttpFoundation\RequestStack;

class CartController extends AbstractController
{


    public function __construct(private CartService $cartService){

        $this->cartService= $cartService;
     }
>>>>>>> origin/master
    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        $cart = $this->cartService->getCartDetails();
        $cart_json =json_encode($cart);
        $carriers = $this->carrierRepository->findAll();
        //return $this->json($cart_json);
        
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'cart' => $cart,
            'carriers' =>$carriers ,
            'cart_json'=> $cart_json,
        ]);
    }

<<<<<<< HEAD
    #[Route('/cart/add/{productId}/{count}', name: 'app_add_to_cart')]
    public function addToCart(string $productId, $count = 1): Response
    {
        $this->cartService->addToCart($productId,$count);
        $cart = $this->cartService->getCartDetails();
        //dd($this->cartService->getCartDetails());
       // return $this->redirectToRoute("app_cart");
        return $this->json($cart);
        
=======
    #[Route('/cart/add/{productId}/{count}', name: 'app_cart')]
    public function addToCart(string $productId ,$count=1): Response
    {   
       // $products= $this->$productId->findById();
        $this->cartService->addToCart($productId,$count);
        dd($this->cartService->getCart());
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
>>>>>>> origin/master
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

    #[Route('/cart/carrier', name: 'app_update_cart_carrier', methods: ["POST"])]
    public function updateCartCarrier(Request $req): Response
    {
        $id = $req->getPayload()->get("carrierId");
        
        $carrier = $this->carrierRepository->findOneById($id);

        if(!$carrier){
            return $this->redirectToRoute("app_home");
        }
        $this->cartService->update("carrier", [
            "id"=> $carrier->getId(),
            "name"=> $carrier->getName(),
            "description"=> $carrier->getDescription(),
            "price"=> $carrier->getPrice(),
        ]);

        return $this->redirectToRoute("app_cart");

      
        
    }

}
