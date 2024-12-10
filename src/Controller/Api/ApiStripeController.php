<?php

namespace App\Controller\Api;

use App\Repository\OrderRepository;
use Stripe\StripeClient;
use App\Services\StripeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class ApiStripeController extends AbstractController
{
    #[Route('/api/stripe/payment-intent/{orderId}', name: 'app_stripe_payment-intent' , methods:['POST'])]
    public function index($orderId,StripeService $stripeservice, Request $req,OrderRepository $orderRepo,EntityManagerInterface $em): Response
    {
        try{
                $stripeSecretKey =$stripeservice->getPrivatekey() ;
                //$items =$req->getPayload()->get('items');
                $order= $orderRepo->findOneById($orderId);


                if (!$order){
                    return $this->json(['error' => "order not found ! "]);

                }
                //dd($items);
                $stripe = new StripeClient($stripeSecretKey);
                $paymentIntent = $stripe->paymentIntents->create([
                    'amount' => $order->getOrderCostTtc(),
                    'currency' => 'usd',
                    // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
                    'automatic_payment_methods' => [
                        'enabled' => true,
                    ],
                ]);
                $output = [
                    'clientSecret' => $paymentIntent->client_secret,
                ];

                $order->setStripeClientSecret($paymentIntent->client_secret);

                $em->persist($order);
                $em->flush();
            
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
        // public function calculateOrderAmount($items){
        //     return 1400;
        //     //$cart->sub_total_with_carrier;

        // }

   
}
