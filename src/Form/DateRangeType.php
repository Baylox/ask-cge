<?php

namespace App\Form;

use App\DateRange;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\DataMapperInterface;


class DateRangeType extends AbstractType implements DataMapperInterface
{

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DateRange::class,
        ]);
    }

    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        if (null === $viewData) {
            return;
        }

        if (!$viewData instanceof DateRange) {
            throw new UnexpectedTypeException($viewData, DateRange::class);
        }

        $forms = iterator_to_array($forms);
        $forms['from']->setData($viewData->getFrom()->format('Y-m-d'));
        $forms['to']->setData($viewData->getTo()->format('Y-m-d'));
    }

    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        $forms = iterator_to_array($forms);

        $viewData = new DateRange(
            new \DateTimeImmutable($forms['from']->getData()),
            new \DateTimeImmutable($forms['to']->getData()),
        );
    }

        public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('from', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('to', DateType::class, [
                'widget' => 'single_text',
            ])
            ->setDataMapper($this);
    }
}
