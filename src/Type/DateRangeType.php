<?php

namespace App\Type;

use App\DateRange;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class DateRangeType extends Type
{
    const TYPE = 'date_range';

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
            \DateTimeImmutable::createFromTimestamp($to), // À partir de PHP 8.4
        );
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::TYPE;
    }
}
