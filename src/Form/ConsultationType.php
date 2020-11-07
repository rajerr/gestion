<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\Consultation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ConsultationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            //->add('date')
            ->add('poids')
            ->add('temperature')
            ->add('tension')
            ->add('diagnostique')
            ->add('patient',EntityType::class,[
                'class' => Patient::class,
                'choice_label' =>function($patient){
                    return $patient->getNom()." ".$patient->getPrenom()." ".$patient->getUsername();
                }
            ])
            //->add('medecin')
            ->add('Enregistrer', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
        ]);
    }
}
