<?php

namespace App\Form;

use App\Entity\Evenement;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Nom de l\'événement'
            ])
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'sport' => 'sport',
                    'cinema' => 'cinema',
                    'théatre' => 'théatre',
                    'restaurant' => 'restaurant',
                    'randonnée' => 'randonée'
                ]
            ])
            ->add('lieu', TextType::class, [
                'label' => 'Lieu : '
            ])
            ->add('nbParticipantsMax', IntegerType::class, [
                'label' => 'Nombre de participants maximum',
                'attr' => array('min' => 2)
            ])
            ->add('date', DateTimeType::class,[
                'widget' => 'choice'
            ])
            ->add('description')
            ->add('prix',IntegerType::class, [
                'label' => 'Prix',
                'attr' => array('min' => 0)
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
