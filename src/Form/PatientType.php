<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id',EntityType::class,[
                'class' => User::class,
                'choice_label' =>function($user){
                    return $user->getUsername();
                }
            ])
            ->add('groupeSanguin', ChoiceType::class, [
                'choices' => [
                    'Groupe sanguin' => [
                        'selectionnez' => '',
                        '0+' => '0+',
                        '0-' => '0-',
                        'A+' => 'A+',
                        'A-' => 'A-',
                        'B+' => 'B+',
                        'B-' => 'B-',
                        'AB+' => 'AB+',
                        'AB-' => 'AB-',
                    ],
                ],
            ])
            ->add('situationMatrimoniale')
            ->add('profession')
            ->add('dateNaissance')
            ->add('etat')
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}