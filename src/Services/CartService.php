<?php

namespace App\Services;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService {

    public function __construct(private RequestStack $requestStack, private ProductRepository $productRep){


       $this->session = $requestStack ->getSession();
       $this->productRep= $productRep;
    }

    public function getCart()
    {

       return $this->session->get("cart", []);
    }

    public function updateCart($cart)
    {

       return $this->session->get("cart", $cart);
    }

    public function addToCart($productId ,$count=1)
    {

        // ['id'=>3,]

        //         ;
        $cart = $this->getCart() ;
        if( !empty($cart[$productId])){

            $cart[$productId] += $count ;

        }else{

            $cart[$productId] = $count ;

        }
        $this->updateCart($cart) ;
    }

    public function removeToCart($productId ,$count=1)
    {}


    public function clearProductFromCart($productId)
    {}
}