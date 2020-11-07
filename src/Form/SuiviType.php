<?php

namespace App\Form;

use App\Entity\Suivi;
use App\Entity\Consultation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class SuiviType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            //->add('dateprise')
            ->add('dateretour')
            ->add('timeretour')
            ->add('consultation',EntityType::class,[
                'class' => Consultation::class,
                'choice_label' =>function($consultation){
                    return $consultation->getLibelle();
                }
            ])
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'Genre' => [
                        'selectionnez' => '',
                        'ENCOURS' => 'ENCOURS',
                        'MANQUER' => 'MANQUER',
                        'TERMINER' => 'TERMINER',
                    ],
                ],
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Suivi::class,
        ]);
    }
}
