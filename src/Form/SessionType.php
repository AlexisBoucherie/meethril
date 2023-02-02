<?php

namespace App\Form;

use App\Entity\Session;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('place')
            ->add('date', DateTimeType::class, [
                "minutes" => [
                    '00',
                    '15',
                    '30',
                    '45'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'One-Shot' => 'One-Shot',
                    'Campagne' => 'Campagne',
                ]
            ])
            ->add('image')
            ->add('maxPlayerNb')
            ->add('description');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
