<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                'label' => 'Lieu : '
            ])
            ->add('nom', TextType::class, ['label' => 'Nom : '])
            ->add('dateDebut', DateType::class, [
                'label' => 'Date de début de la sortie : ',
                'widget' =>'single_text'])

            ->add('duree', ChoiceType::class, [
                'label' => "Durée : ",
                'choices' => [
                    '30 minutes' => '30',
                    '60 minutes' => '60',
                    '1h30' => '90',
                    '2h' => '120',
                    '2h30' => '150',
                    '3h' => '180',
                    '3h30' => '210',
                    '4h' => '240',
                    '5h' => '300',
                    '>5h' => '3000',
                ]
            ])
            ->add('nbInscription', NumberType::class, ['label' => 'Nombre de places : '])
            ->add('dateCloture', DateType::class, [
                'label' => 'Date de clôture des inscriptions  : ',
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
