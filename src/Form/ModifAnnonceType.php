<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Type;
use Symfony\Component\Validator\Constraints\File;

class ModifAnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('designation', TextType::class)
        ->add('description', TextareaType::class)
        ->add('ville', TextType::class)
        ->add('region', TextType::class)
        ->add('codepostal', NumberType::class)
        ->add('nom', TextType::class)
        ->add('mail', EmailType::class)
        ->add('telephone', TelType::class)
        ->add('type', EntityType::class, array( 'mapped'=>false, 'label'=>'Type à relier', 'class'=>Type::class,'choice_label'=>'libelle', 'expanded'=>false, 'multiple' => false))
        ->add('prix', NumberType::class)
        ->add('modifier', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
