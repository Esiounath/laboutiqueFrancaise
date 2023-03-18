<?php

namespace App\Controller\Admin;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;


class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            TextField::new('name')->setFormType(TextType::class)->setFormTypeOptions([
                'attr' => ['style' => 'text-transform: capitalize;'],
            ]),
            SlugField::new('slug')->setTargetFieldName('name'),
            TextareaField::new('subtitle')->setFormType(TextType::class)->setFormTypeOptions([
                'attr' => ['style' => 'text-transform: capitalize;'],
            ]),
            TextareaField::new('description')->setFormType(TextareaType::class)->setFormTypeOptions([
                'attr' => ['style' => 'text-transform: capitalize;'],
            ]),
            ImageField::new('illustration')
                ->setBasePath('uploads/') // chemin de base pour accéder aux images
                ->setUploadDir('public/uploads/')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            MoneyField::new('price')
            ->setCurrency('EUR')
            ->setNumDecimals(2),
            BooleanField::new('isBest'),
            AssociationField::new('category')
        ];
    }
}
