<?php 
namespace App\Services;

use App\Repository\CarrierRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartService {
    private SessionInterface $session;

<<<<<<< HEAD
    public function __construct(
        private RequestStack $requestStack,
        private ProductRepository $productRepo,
        private CarrierRepository $carrierRepo,
    ) {
        // Accessing the session in the constructor is *NOT* recommended, since
        // it might not be accessible yet or lead to unwanted side-effects
        $this->session = $requestStack->getSession();
        $this->productRepo = $productRepo;
      
    }
=======
    // public function __construct(private RequestStack $requestStack, private ProductRepository $productRep){


    //    $this->session = $requestStack ->getSession();
    //    $this->productRep= $productRep;
    // }
>>>>>>> origin/master

    public function get($key)
    {
        return $this->session->get($key, []);
    }
    public function update($key,$cart)
    {
        return $this->session->set($key, $cart);
    }
    public function addToCart($productId, $count = 1)
    {
        // [
        //     '1' => 3,
        //     '25' => 1,
        // ]
        $cart = $this->get('cart');

        if(!empty($cart[$productId])){
            // product exist in cart
            $cart[$productId] += $count;
        }else{
            // product not exist
            $cart[$productId] = $count;
        }

        $this->update("cart",$cart);
    }

<<<<<<< HEAD
    public function removeToCart($productId, $count = 1)
    {
        $cart = $this->get('cart');

        if(isset($cart[$productId])){
            if($cart[$productId]  <= $count){
                unset($cart[$productId]);
            }else{
                $cart[$productId] -= $count;
            }

            $this->update("cart",$cart);
        }

    }

    public function clearCart()
    {
        $this->update("cart",[]);
    }
    public function getCartDetails()
    {
       
        $cart = $this->get('cart');;
        $result = [
            'items' => [],
            'sub_total' => 0,
            'cart_count' => 0,
            'quantity' => 0,
        ];

        $sub_total = 0;
        foreach ($cart as $productId => $quantity) {

            $product = $this->productRepo->find($productId);
            
            if($product){
                $current_sub_total = $product->getSoldePrice()*$quantity;
                $sub_total += $current_sub_total;
                $result['items'][] = [
                    'product' => [
                        'id'=>$product->getId(),
                        'name'=>$product->getName(),
                        'slug'=>$product->getSlug(),
                        'imageUrls'=>$product->getImageUrls(),
                        'soldePrice'=>$product->getSoldePrice(),
                        'regularPrice'=>$product->getRegularPrice(),
                    ],
                    'quantity' => $quantity,
                    'taxe' => 0,
                    'sub_total' => $current_sub_total,
                    
                ];
                $result['sub_total'] = $sub_total;
                $result['taxe'] = 0 ;
                $result['cart_count'] += $quantity;
                $result['quantity'] += $quantity;

               

            }else{
                unset($cart[$productId]);
                $this->update("cart",$cart);
            }

            
        }
       // dd ('carrier test', $this->carrierRepo->findAll()[0]);
      $carrier =$this->get("carrier");
      if(!$carrier){
        $carrier = $this->carrierRepo->findAll()[0];
        $carrier = [
            "id" => $carrier -> getId(),
            "name" => $carrier -> getName(),
            "description"=> $carrier ->getDescription(),
            "price"=> $carrier -> getPrice(),
                  ];
        $carrier =$this->update("carrier", $carrier);
       }
        $result["carrier"] = $carrier ;
        $result["sub_total_with_carrier"] = $result["sub_total"] + $carrier["price"];
        return $result;
    }

 
    


=======
    public function removeToCart($productId ,$count=1)
    {
        $cart =$this->getCart();
        
        if(isset($cart[$productId])){

            if($cart[$productId] <= $count){
                unset($cart);
               
             }
             else{
                $cart[$productId] -= $count;
             }

             $this->updateCart($cart);
           

        }
    }


    public function clearProductFromCart()
    {

        $this->updateCart([]) ;
    }
>>>>>>> origin/master
}