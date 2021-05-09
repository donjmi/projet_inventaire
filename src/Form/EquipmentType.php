<?php

namespace App\Form;

use App\Entity\State;
use App\Entity\Bulding;
use App\Entity\Category;
use App\Entity\Equipment;
use App\Entity\Planning;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount')
            ->add('description')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                "choice_label" => function ($category) {
                    return ($category->getName());
                }
            ])
            ->add('bulding', EntityType::class, [
                'class' => Bulding::class,
                "choice_label" => function ($bulding) {
                    return ($bulding->getDescription());
                }
            ])
            ->add('state', EntityType::class, [
                'class' => State::class,
                "choice_label" => function ($state) {
                    return ($state->getName());
                }
            ])
            ->add('planning', EntityType::class, [
                'class' => Planning::class,
                "choice_label" => function ($planning) {
                    return ($planning->getYear());
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipment::class,
        ]);
    }
}