<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Service;
use App\Entity\Structure;
use App\Repository\UserRepository;
use App\Repository\ServiceRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class StructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control shadow',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Nom de la structure',
                'label_attr' => [
                    'class' => 'form-label'
                ],
            ])
            ->add('users', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (UserRepository $r) {
                    return $r
                        ->createQueryBuilder('i')
                        ->orderBy('i.fullName', 'ASC');
                },
                'label' => 'Nom du franchisé',
                'label_attr' => [
                    'class' => 'form-label mt-2'
                ],
                'attr' => [
                    'class' => 'form-select'
                ],
                'choice_label' => 'fullName',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('postalAddress', TextType::class, [
                'attr' => [
                    'class' => 'form-control shadow',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'required' => false,
                'label' => 'Adresse postale',
                'label_attr' => [
                    'class' => 'form-label mt-2'
                ],
            ])
            ->add('phoneNumber', TelType::class, [
                'attr' => [
                    'class' => 'form-control shadow',
                ],
                'required' => false,
                'label' => 'Téléphone',
                'label_attr' => [
                    'class' => 'form-label mt-2'
                ]
            ])
            ->add(
                'description',
                TextareaType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'min' => 1,
                        'max' => 5
                    ],
                    'required' => false,
                    'label' => 'Description',
                    'label_attr' => [
                        'class' => 'form-label mt-2'
                    ],
                ]
            )
            ->add('isActive', CheckboxType::class, [
                'label' => 'Statut',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input shadow'
                ]
            ])
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'query_builder' => function (ServiceRepository $s) {
                    return $s
                        ->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC');
                },
                'attr' => [
                    'class' => 'form-select',
                ],
                'multiple' => true,
                'expanded' => false,
                'label' => 'Choisissez un ou plusieurs services',
                'label_attr' => [
                    'class' => 'form-label mt-2'
                ],
                'choice_label' => 'name',
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-sm btn-success shadow mt-4'
                ],
                'label' => 'Valider'
            ]);

        // Data transformer USERS
        $builder->get('users')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Structure::class,
        ]);
    }
}
