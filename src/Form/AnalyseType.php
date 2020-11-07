<?php

namespace App\Form;

use App\Entity\Analyse;
use App\Entity\Prescription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AnalyseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('details')
            ->add('prescription',EntityType::class,[
                'class' => Prescription::class,
                'choice_label' =>function($prescription){
                    return $prescription->getLibelle();
                }
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Analyse::class,
        ]);
    }
}
