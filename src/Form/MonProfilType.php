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

            ->add('oldPassword', PasswordType::class, array(
                'label' => 'Ancien mot de passe',
                'mapped' => false,
            ))
            ->add('passwordPlain', RepeatedType::class, array(
                'type' => PasswordType::class,
                'required' => false,
                'mapped' => false,
                'first_options'  => array('label' => 'Nouveau mot de passe'),
                'second_options' => array('label' => 'Confirmation mot de passe'),
                'invalid_message' => 'Les deux mots de passe doivent être identiques',
                'options' => array(
                    'attr' => array(
                        'class' => 'password-field'
                    )
                ),

            ))

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
