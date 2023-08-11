<?php

namespace App\Form;

use App\Entity\Wish;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',null,
                ["label"=> "Nom du souhait : ",
                    "label_attr" => ["class"=>"texteParagraphe"],
                    "attr" =>["class"=>"champFormulaire"]]
            )
            ->add('description', TextareaType::class,
                ["label"=> "Description détaillée : ",
                    "label_attr" => ["class"=>"texteParagraphe"],
                    "attr" =>["rows" => 10, "cols" => 35, "class"=>"champFormulaire"]]
            )
            ->add('author', TextType::class,
                ["label" => "Votre pseudo : ",
                    "label_attr" => ["class"=>"texteParagraphe"],
                    "attr" =>["class"=>"champFormulaire"]]
            )
//            ->add('isPublished')
//            ->add('dateCreated')
            ->add('ajouter', SubmitType::class,
                [
                    "attr" => ["class" => "grosBouton"]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}
