<?php

namespace App\Controller\Api;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;



class ApiOrderController extends AbstractController
{
    #[Route('/api/order', name: 'app_api_order' , methods: ["POST"]) ]
    public function update(Request $req ,OrderRepository $orderRep ,  EntityManagerInterface $em): Response
    {

        $data = $req->getPayload();
        $id = $data->get("orderId");
        $order = $orderRep->findOneById($id);

       // dd($data);
        if(!$order){
           return $this->redirectToRoute('/chachout');
        }

        $order->setBillingAddress($data->get('billing_address'))
        ->setShippingAddress($data->get('shipping_address'));

        $em->persist($order);
        $em->flush();
       return $this->render('api/api_order/index.html.twig', [
            'controller_name' => 'ApiOrderController',
        ]);
    }
}
