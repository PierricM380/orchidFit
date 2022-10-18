<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Partner;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
                ],
                'label' => 'Nom du partnaire',
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
                ],
                'required' => false,
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'form-label mt-2'
                ],
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Statut',
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'required' => false
            ])
            ->add('imageFile', VichImageType::class, [
                'attr' => [
                    'class' => 'form-control mb-1'
                ],
                'label' => 'Image du partenaire',
                'label_attr' => [
                    'class' => 'form-label mt-2'
                ],
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partner::class,
        ]);
    }
}
