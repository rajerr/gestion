<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Medecin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MedecinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('id',EntityType::class,[
            'data_class' => null,
            'mapped' => false, 
            'class' => User::class,
            'choice_label' =>function($user){
                return $user->getUsername()." ".$user->getProfile()->getLibelle();
            }
        ])
            ->add('specialite')
            ->add('biographie')
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}
