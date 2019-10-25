<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreationSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'NomLieu',
            ])
            ->add('nom', TextType::class, ['label' => 'Nom : '])
            ->add('dateDebut', DateType::class, [
                'label' => 'Date de début : ',
                'widget' =>'single_text'])
            ->add('duree', null, ['label' => 'Durée : '])
            ->add('nbInscription', NumberType::class, ['label' => 'Nombre de place : '])
            ->add('dateCloture', DateType::class, [
                'label' => 'Date de fin : ',
                'widget' =>'single_text'])
            ->add('description', TextareaType::class, ['label' => 'Description : ']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }

    public function villes(EntityManagerInterface $em){
        $repo = $em->getRepository(Ville::class);
        $villes = $repo->findAll();

        ["villes"=>$villes];

    }
    public function sites(EntityManagerInterface $em){
        $repo = $em->getRepository(Site::class);
        $sites = $repo->findAll();

        ["sites"=>$sites];

    }
    public function rueByLieu(EntityManagerInterface $em){
        $repo = $em->getRepository(Lieu::class);
        $lieux = $repo->findBy(
        [],['rue']
            );

        ["lieux"=>$lieux];

    }
}
