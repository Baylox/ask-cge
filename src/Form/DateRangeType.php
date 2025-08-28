<?php

namespace App\Form;

use App\DateRange;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateRangeType extends Type
{
    const TYPE = 'date_range';

    public function getName(): string
    {
        return self::TYPE;
    }

    /**
     * @inheritDoc
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value instanceof DateRange) {
            throw new \InvalidArgumentException('$value should be an instance of App\\DateRange.');
        }

        return sprintf('%u-%u', $value->getFrom()->getTimestamp(), $value->getTo()->getTimestamp());
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): DateRange
    {
        sscanf($value, '%u-%u', $from, $to);

        $fromDate = new \DateTimeImmutable();
        $fromDate = $fromDate->setTimestamp($from);

        return new DateRange(
            $fromDate,
            \DateTimeImmutable::createFromTimestamp($to), // A partir du 8.4
        );
    }



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
