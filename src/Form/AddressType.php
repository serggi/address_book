<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('number', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('zip', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('country', CountryType::class, [
                'constraints' => [
                    new Country()
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
