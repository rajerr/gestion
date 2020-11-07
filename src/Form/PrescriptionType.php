<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\Prescription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PrescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            //->add('date')
            ->add('description')
            ->add('consultation',EntityType::class,[
                'class' => Consultation::class,
                'choice_label' =>function($consultation){
                    return $consultation->getLibelle();
                }
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prescription::class,
        ]);
    }
}
