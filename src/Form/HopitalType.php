<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Hopital;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HopitalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('adresse')
            ->add('contact')
            ->add('email')
            ->add('boitePostal')
            ->add('fax')
            ->add('logo', FileType::class, [
                'label' => 'selectionner logo',

                // unmapped means that this field is not associated to any entity property
                'mapped' => true,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
            ])
            // ->add('statut')
            ->add('ville')
            ->add('user',EntityType::class,[
                'class' => User::class,
                'choice_label' =>function($user){
                    return $user->getUsername();
                }
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hopital::class,
        ]);
    }
}
