<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiPaypalController extends AbstractController
{
    #[Route('/api/api/paypal', name: 'app_api_api_paypal')]
    public function index(): Response
    {
        return $this->render('api/api_paypal/index.html.twig', [
            'controller_name' => 'ApiPaypalController',
        ]);
    }
}
