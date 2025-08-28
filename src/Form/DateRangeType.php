<?php

namespace App\Form;

use App\DateRange;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateRangeType extends Type
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('field_name')
        ;
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
