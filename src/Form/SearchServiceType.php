<?php

namespace App\Form;

use App\Data\SearchService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SearchServiceType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('se', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'rechercher un service'
                ],
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Actif(s)',
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'required' => false
            ])
            ->add('isDisabled', CheckboxType::class, [
                'label' => 'Inactif(s)',
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchService::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}