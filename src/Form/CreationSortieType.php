<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
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
            ->add('nom', null, ['label' => 'Nom : '])
            ->add('datedebut', null, ['label' => 'Date de début : '])
            ->add('duree', null, ['label' => 'Durée : '])
            ->add('nbinscription', null, ['label' => 'Nombre de participant : '])
            ->add('datecloture', null, ['label' => 'Date de fin : '])
            ->add('description', null, ['label' => 'Description : ']);
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
