<?php

namespace App\Form;

use App\Entity\Partner;
use App\Entity\Structure;
use App\Repository\StructureRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PartnerType extends AbstractType
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
                'label' => 'Nom du partnaire',
                'label_attr' => [
                    'class' => 'form-label'
                ],
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
            ->add('description', TextareaType::class, [
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
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Statut',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input shadow'
                ]
            ])
            ->add('structure', EntityType::class, [
                'class' => Structure::class,
                'query_builder' => function (StructureRepository $r) {
                    return $r
                        ->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC');
                },
                'label' => 'Structures',
                'label_attr' => [
                    'class' => 'form-label mt-2'
                ],
                'required' => false,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary btn-sm shadow mt-4'
                ],
                'label' => 'Valider'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partner::class,
        ]);
    }
}