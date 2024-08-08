<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Component\Form\FormEvents;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Form\FormBuilderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        public UserPasswordHasherInterface $userPasswordHasher
    ) {}
    
    public static function getEntityFqcn(): string
    {
        return User::class;
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
            ChoiceField::new('civility')->setChoices([
                'Monsieur' => 'Mr',
                'Madame' => 'Mme',
                'Mademoiselle' => 'Mlle'
            ]),
            TextField::new('full_name'),
            EmailField::new('email'),
            AssociationField::new('addresses'),
            TextField::new('password')
            ->setFormType(RepeatedType::class)
            ->setFormTypeOptions([
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Password',
                    'row_attr'=> [
                        'class'=>"col-md-6 col-xxl-5"
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirm Password',
                    'row_attr'=> [
                        'class'=>"col-md-6 col-xxl-5"
                    ],
                ],
                'mapped' => false,
            ])
            ->setRequired($pageName ===  Crud::PAGE_NEW)
            ->onlyOnForms(),
        ];
    }

    public function createNewFormBuilder(
        EntityDto $entityDto, 
        KeyValueStore $formOptions, 
        AdminContext $context): FormBuilderInterface
        {
        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);

        return $this->addPasswordEventListener($formBuilder);
    }
    public function createEditFormBuilder(
        EntityDto $entityDto, 
        KeyValueStore $formOptions, 
        AdminContext $context): FormBuilderInterface
        {
        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);

        return $this->addPasswordEventListener($formBuilder);
    }

    public function addPasswordEventListener(FormBuilderInterface $formBuilder){
        return $formBuilder->addEventListener(FormEvents::POST_SUBMIT, $this->hashPassword());
    }

    public function hashPassword(){
        return function($event){
            $form = $event->getForm();
            $entity = $form->getData(); // Get the entity from the form
    
            if(!$form->isValid() || !$entity instanceof User){
                return;
            }
    
            $password = $form->get('password')->getData();
    
            if($password === null){
                return;
            }
    
            // You don't need to check for $this->getUser() here
    
            $hash = $this->userPasswordHasher->hashPassword($entity, $password);
            $entity->setPassword($hash); // Set the hashed password on the entity
        };
    }
    
    
}
