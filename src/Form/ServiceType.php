<?php

namespace App\Form;

use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ServiceType extends AbstractType
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
                'label' => 'Nom du service',
                'label_attr' => [
                    'class' => 'form-label'
                ],
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Statut',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input shadow'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
