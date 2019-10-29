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
            ->add('pseudo', TextType::class, ['label'=>'Pseudo', "empty_data" => ''])
            ->add('prenom', TextType::class, ['label'=>'Prenom', "empty_data" => ''])
            ->add('nom', TextType::class, ['label'=>'Nom', "empty_data" => ''])
            ->add('telephone', TelType::class, ['label'=>'Téléphone', "empty_data" => ''])
            ->add('email',EmailType::class, ['label'=>'Email', "empty_data" => ''])
//            ->add('password', RepeatedType::class, [
//                'type' => PasswordType::class,
//                'first_options'  => array('label' => 'Password'),
//                'second_options' => array('label' => 'Vôtre ancien mot de passe'),
//                'invalid_message' => 'Your passwords do not match!',
//                'constraints' => [
//                    new NotBlank([
//                        'message' => 'Please enter a password',
//                    ]),
//                    new Length([
//                        'min' => 6,
//                        'minMessage' => 'Your password should be at least {{ limit }} characters',
//                        // max length allowed by Symfony for security reasons
//                        'max' => 4096,
//                    ]),
//                ],
//            ])
            ->add('oldPassword', PasswordType::class, array(
                'label' => 'Ancien MDP',
                'mapped' => false,
            ))
            ->add('passwordPlain', RepeatedType::class, array(
                'type' => PasswordType::class,
                'required' => false,
                'mapped' => false,
                'first_options'  => array('label' => 'Nouveau mot de passe'),
                'second_options' => array('label' => 'Confirmer vôtre mot de passe'),
                'invalid_message' => 'Les deux mots de passe doivent être identiques',
                'options' => array(
                    'attr' => array(
                        'class' => 'password-field'
                    )
                ),

            ))
            /*->add('site', EntityType::class, [
                'class'=> Site::class,
                //Attribut utilisé pour l'affichage
                //'choice_label' => 'nom_site',
                'choice_label' => function($site){
                    return $site->getNomSite();
                },
                'attr' => [
                  'readonly'=> 'readonly'
                ],
                //Fait une requête particulière
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c');
                }
            ])*/
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
