<?php

namespace App\Controller;
use App\Services\CartService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\AddressRepository;



class CheckoutController extends AbstractController
{

    public function __construct(
        private CartService $cartService,
        private RequestStack $requestStack,

    ) {
        $this->cartService = $cartService;
        $this->session = $requestStack->getSession();

    }

    #[Route('/checkout', name: 'app_checkout')]
    public function index(AddressRepository $addressRepository): Response
    {
        
        $cart = $this->cartService->getCartDetails();

        if(!(count($cart["items"]))){
            return $this->redirectToRoute('app_home');
        }

        $user = $this->getUser();
        if(!$user){
            $this->session->set("next","app_checkout");
           return $this->redirectToRoute("app_login");
        }
        $addresses = $addressRepository->findByUser($user);


        //$cart_json =json_encode($cart);

        return $this->render('checkout/index.html.twig', [
            'controller_name' => 'CheckoutController',
            'cart'=>$cart,
            'addresses'=>$addresses,
        ]);
    }
}
