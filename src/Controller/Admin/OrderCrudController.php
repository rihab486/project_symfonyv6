<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }
    public function configureActions(Actions $actions): Actions{
        return $actions 
        ->add(Crud::PAGE_EDIT, Action::INDEX)
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->add(Crud::PAGE_EDIT, Action::DETAIL)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('client_name'),
            TextField::new('delivrey_address'),
            TextField::new('billing_address'),
            TextField::new('shipping_address'),
            IntegerField::new('quantity'),
            BooleanField::new('isPaid'),
            MoneyField::new('carrier_price')->SetCurrency("EUR"),
            MoneyField::new('order_cost')->SetCurrency("EUR"),
            MoneyField::new('taxe')->SetCurrency("EUR"),
            MoneyField::new('order_cost_ttc')->SetCurrency("EUR"),

        ];
    }
   
}
