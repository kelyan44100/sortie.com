<?php

namespace App\Form;

use App\Entity\Sortie;
use App\Entity\Lieu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreationSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, ['label' => 'Nom : '])
            ->add('datedebut', null, ['label' => 'Date de début : '])
            ->add('duree', null, ['label' => 'Durée : '])
            ->add('nbinscription', null, ['label' => 'Nombre de participant : '])
            ->add('datecloture', null, ['label' => 'Date de fin : '])
            ->add('description', null, ['label' => 'Description : '])
            ->add('etatsortie', null, ['label' => 'Statut : '])
            ->add('urlphoto', null, ['label' => 'Photo : '])
            ->add('organisateur', null, ['label' => 'Organisateur : '])
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
