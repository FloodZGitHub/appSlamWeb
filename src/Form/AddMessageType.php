<?php

namespace App\Form;

use App\Entity\Messagechat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Utilisateur;

class AddMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu', TextType::class)
            ->add('userrecoi', EntityType::class, array( 'mapped'=>false, 'label'=>'Utilisateur à relier', 'class'=>Utilisateur::class,'choice_label'=>'prenom', 'expanded'=>false, 'multiple' => false))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messagechat::class,
        ]);
    }
}
