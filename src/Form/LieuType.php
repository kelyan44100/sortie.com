<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ville',EntityType::class, [
                "class" => 'App\Entity\Ville',
                'choice_label' => 'nom_ville',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                        ->orderBy('v.nom_ville', 'ASC');
                }

            ])
            /*->add('ville', TextType::Class, [
                "label" => "Ville"
            ])*/
            ->add('nom_lieu', TextType::Class, [
                "label" => "Nom du lieu"
            ])
            ->add('rue', TextType::Class, [
                "label" => "Rue"
            ])
            ->add('latitude', NumberType::class, [
                "label" => "Latitude"
            ])
            ->add('longitude', NumberType::class, [
                "label" => "Longitude"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }

    public function villes(EntityManagerInterface $em){
        $repo = $em->getRepository(Ville::class);
        $villes = $repo->findAll();

        ["villes"=>$villes];

    }
}
