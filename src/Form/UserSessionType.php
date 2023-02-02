<?php

namespace App\Form;

use App\Entity\UserSession;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('userIsOwner')
            ->add('pcName')
            ->add('pcRace')
            ->add('pcClass')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('userId')
            ->add('sessionId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserSession::class,
        ]);
    }
}
