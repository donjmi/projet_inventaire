<?php

namespace App\Form;

use App\Entity\State;
use App\Entity\Bulding;
use App\Entity\Category;
use App\Entity\Planning;
use App\Entity\Equipment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EquipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', null, [
                'label' => 'Qté'
            ])
            ->add('room', TextType::class, [
                'label' => 'Lieu'
            ])
            ->add('description', TextType::class, [
                'label' => 'Description'
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => "Categorie",
                'placeholder' => "Choisir Categorie",
                "choice_label" => function ($category) {
                    return ($category->getName());
                }
            ])
            ->add('bulding', EntityType::class, [
                'class' => Bulding::class,
                'label' => "Bâtiment",
                'placeholder' => "Choisir Bâtiment",
                "choice_label" => function ($bulding) {
                    return ($bulding->getDescription());
                }
            ])
            ->add('state', EntityType::class, [
                'class' => State::class,
                'label' => "Etat",
                'placeholder' => "Choisir Etat",
                "choice_label" => function ($state) {
                    return ($state->getName());
                }
            ])
            ->add('planning', EntityType::class, [
                'class' => Planning::class,
                'label' => "Année",
                'placeholder' => "Année remplacement",
                "choice_label" => function ($planning) {
                    return ($planning->getYear());
                }
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer',
                // 'download_label' => 'Télécharger',
                'download_uri' => false,
                // 'image_uri' => true,
                // 'imagine_pattern' => 'biensXs',
                // 'asset_helper' => true,
                'label' => 'Ajoutez l\'image'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipment::class,
        ]);
    }
}