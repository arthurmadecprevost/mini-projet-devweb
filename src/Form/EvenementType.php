<?php

namespace App\Form;

use App\Entity\Evenement;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Nom de l\'événement',
                'attr' => ['class' => 'form-control']
            ])
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'sport' => 'sport',
                    'cinema' => 'cinema',
                    'théatre' => 'théatre',
                    'restaurant' => 'restaurant',
                    'randonnée' => 'randonée'
                ],
                'label' => 'Catégorie',
                'attr' => ['class' => 'form-control']
            ])
            ->add('lieu', TextType::class, [
                'label' => 'Lieu',
                'attr' => ['class' => 'form-control']
            ])
            ->add('nbParticipantsMax', IntegerType::class, [
                'label' => 'Nombre de participants maximum',
                'attr' => ['min' => 2, 'class' => 'form-control']
            ])
            ->add('date', DateTimeType::class,[
                'widget' => 'choice',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control']
            ])
            ->add('prix',IntegerType::class, [
                'label' => 'Prix',
                'attr' => ['min' => 0, 'class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
