<?php

namespace App\Form;

use App\Entity\Products;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class ProductType extends AbstractType
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
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ingresa el nombre']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripcion',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ingresa la descripcion']
            ])
            ->add('mark', TextType::class, [
                'label' => 'Marca',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ingresa la marca']
            ])
            ->add('price', NumberType::class, [
                'label' => 'Precio',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ingresa el precio']
            ])
            ->add('category', EntityType::class, array(
                'label' => 'Categoria',
                'attr' => ['class' => 'form-control'],
                'class' => Categories::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.active = 1')
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
                'mapped' => false,
                'placeholder' => '--Selecciona la categoria--',
            ))
            ->add('save', SubmitType::class, [
                'label' => 'Guardar',
                'attr' => ['class' => 'btn btn-success form-control mt-3']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
