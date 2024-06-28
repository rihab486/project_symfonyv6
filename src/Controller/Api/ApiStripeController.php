<?php

namespace App\Controller\Api;

use Stripe\StripeClient;
use App\Services\StripeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiStripeController extends AbstractController
{
    #[Route('/api/stripe/payment-intent', name: 'app_stripe_payment-intent' , methods:['POST'])]
    public function index(StripeService $stripeservice, Request $req): Response
    {
        try{
                $stripeSecretKey =$stripeservice->getPrivatekey() ;
                $items =$req->getPayload()->get('items');

                //dd($items);
                $stripe = new StripeClient($stripeSecretKey);
                $paymentIntent = $stripe->paymentIntents->create([
                    'amount' => $this->calculateOrderAmount($items),
                    'currency' => 'usd',
                    // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
                    'automatic_payment_methods' => [
                        'enabled' => true,
                    ],
                ]);
                $output = [
                    'clientSecret' => $paymentIntent->client_secret,
                ];
            
                //echo json_encode($output);
        
                    return $this->json($output);
                
                // return $this->render('api/api_stripe/index.html.twig',[
                //     'controller_name' => 'ApiStripeController',
                // ]);
            }
        catch(\Throwable $th){

                return $this->json(['error' =>$th->getMessage()]);

            }

        }
        public function calculateOrderAmount($items){
            return 1400;
            //$cart->sub_total_with_carrier;

        }

   
}
