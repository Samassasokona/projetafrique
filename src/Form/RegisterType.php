<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Votre prénom',
                'constraints'=> new Length([
                    'min'=> 2,
                    'max'=> 30
                ]),
                'attr' => [
                    'placeholder'=>'saisissez votre prenom'
                    ]
            ])
            ->add('nom', TextType::class, [
                'label' => 'Votre nom',
                'constraints'=> new Length([
                    'min'=> 2,
                    'max'=> 30
                ]),
                'attr' => [
                    'placeholder'=>'saisissez votre nom'
                    ]
            ])

            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'constraints'=> new Length([
                    'min'=> 2,
                    'max'=> 60
                ]),
                'attr' => [
                    'placeholder'=>'saisissez votre email'
                    ]

            ])
            ->add('password', PasswordType::class,[
                'label' => 'Votre mot de passe',
                'attr' => [
                    'placeholder'=>'saisissez votre mot de passe'
                    ]
            ])
        //    ->add('password_comfirm', PasswordType::class,[
        //     'label' => 'Confimer votre mot de passe',
        //     'napped' => false, 
        //     'attr' => [
        //         'placeholder'=>'confirmer'
        //         ] 
        //    ])

           ->add('submit', SubmitType::class,[
               
            'label' => "S'incrire"
            
           ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
