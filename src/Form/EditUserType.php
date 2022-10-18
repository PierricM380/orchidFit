<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('fullName', TextType::class, [
            'label' => 'Prénom / Nom',
            'label_attr' => [
                'class' => 'form-label'
            ],
            'attr' => [
                'class' => 'form-control',
            ]
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email',
            'label_attr' => [
                'class' => 'form-label mt-2',
            ],
            'attr' => [
                'class' => 'form-control',
                'minlenght' => '2',
                'maxlenght' => '180'
            ]
        ])
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'form-label  mt-2'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ],
            'second_options' => [
                'label' => 'Confirmation du mot de passe',
                'label_attr' => [
                    'class' => 'form-label  mt-2'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ],
            'invalid_message' => 'Les mots de passe ne correspondent pas'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
