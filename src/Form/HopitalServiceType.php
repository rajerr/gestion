<?php

namespace App\Form;

use App\Entity\Hopital;
use App\Entity\Medecin;
use App\Entity\Service;
use App\Entity\HopitalService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HopitalServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hopital',EntityType::class,[
                'class' => Hopital::class,
                'choice_label' =>function($hopital){
                    return $hopital->getNom();
                }
            ])
            ->add('service',EntityType::class,[
                'class' => Service::class,
                'choice_label' =>function($service){
                    return $service->getNom();
                }
            ])
            ->add('medecin',EntityType::class,[
                'class' => Medecin::class,
                'choice_label' =>function($medecin){
                    return $medecin->getNom()." ".$medecin->getPrenom()." ".$medecin->getSpecialite();
                }
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HopitalService::class,
        ]);
    }
}
