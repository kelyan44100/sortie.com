<?php

namespace App\Form;

use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreationSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('datedebut')
            ->add('duree')
            ->add('nbinscription')
            ->add('datecloture')
            ->add('description')
            ->add('etatsortie')
            ->add('urlphoto')
            ->add('organisateur')
            ->add('lieux_no_lieu')
            ->add('etats_no_etat')
            ->add('inscriptions_no_inscription')
            ->add('sites_no_site')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
