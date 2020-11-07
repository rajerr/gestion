<?php

namespace App\Form;

use App\Entity\Resultat;
use App\Entity\Prescription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ResultatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('observation')
            ->add('fichier', FileType::class, [
                'label' => 'selectionner fichier ()',

                // unmapped means that this field is not associated to any entity property
                'mapped' => true,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
            ])
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
            'data_class' => Resultat::class,
        ]);
    }
}
