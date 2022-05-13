<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CredentialsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Nom d\'utilisateur', 'class' => 'form-control bg-dark text-white']
            ])
            ->add('password', PasswordType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Mot de passe', 'class' => 'form-control bg-dark text-white mt-1']
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'w-100 btn btn-primary mt-3']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
