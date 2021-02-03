<?php

namespace App\Form;

use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Codigo',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ingresa el codigo']
            ])
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'required' => 'required',
                'attr' => ['required' => 'required', 'class' => 'form-control', 'placeholder' => 'Ingresa el nombre']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripcion',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ingresa la descripcion']
            ])
            ->add('active', ChoiceType::class, [
                'choices' => ['Si' => 1, 'No' => 0],
                'label' => 'Activa',
                'required' => 'required',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Activa']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Guardar',
                'attr' => ['class' => 'btn btn-success form-control mt-3']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categories::class,
        ]);
    }
}
