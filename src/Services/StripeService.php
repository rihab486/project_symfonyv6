<?php 
namespace App\Services;

use App\Repository\PaymentMethodRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class StripeService {

    public function __construct(
        private RequestStack $requestStack,
        private PaymentMethodRepository $paymentmethodRepo,) {
       
        $this->session = $requestStack->getSession();  
       }
    public function getPublickey(){
        $config = $this->paymentmethodRepo->findOneByName("Stripe");
        if ($_ENV['APP_ENV'] === 'dev'){

            //developpemnt  getTestPublicApiKey
            return $config->getTestPublicApiKey();

        }else{
           //production
           return $config->getProdPublicApiKey();

       }

     }

    public function getPrivatekey(){ 

        $config = $this->paymentmethodRepo->findOneByName("Stripe");
        if ($_ENV['APP_ENV'] === 'dev'){
 
             //developpemnt  getTestPublicApiKey
             return $config->getTestPrivateApiKey();
 
        }else{
            //production
            return $config->getProdPrivateApiKey();
 
        }



    }

}
?>