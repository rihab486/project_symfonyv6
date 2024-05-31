<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
{
    #[Route('/api/address', name: 'app_api_address')]
    public function index(): Response
    {
        return $this->render('api/address/index.html.twig', [
            'controller_name' => 'AddressController',
        ]);
    }
}
