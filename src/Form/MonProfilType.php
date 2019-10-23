<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class MonProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, ['label'=>'Pseudo'])
            ->add('prenom', TextType::class, ['label'=>'Prenom'])
            ->add('nom', TextType::class, ['label'=>'Nom'])
            ->add('telephone', TelType::class, ['label'=>'Téléphone'])
            ->add('email',EmailType::class, ['label'=>'Email'])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Confirmation'),
                'invalid_message' => 'Your passwords do not match!',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('site', EntityType::class, [
                'class'=> Site::class,
                //Attribut utilisé pour l'affichage
                'choice_label' => 'nom_site',
                //Fait une requête particulière
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c');
                }
            ])
            ->add('fileTemp', FileType::class, [
                'label'=> 'Ma photo',
                'mapped' => false,
                'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
