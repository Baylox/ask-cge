<?php

namespace App\Form;

use App\Entity\Board;
use App\Entity\Account;
use App\Entity\BoardState;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class BoardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('state', EnumType::class, ['class' => BoardState::class],)
            ->add('accounts', EntityType::class, [
                'class' => Account::class,
                'choice_label' => 'email',
                'multiple' => true,
            ])
            ->add('range', DateRangeType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'empty_data'=> null,
            'data_class' => Board::class,
        ]);
    }
}
