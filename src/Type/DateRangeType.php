<?php
// src/Type/DateRangeType.php
namespace App\Type;

use App\DateRange;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class DateRangeType extends Type
{
    public const NAME = 'date_range';

    public function getName(): string
    {
        return self::NAME;
    }
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        // On stocke sous forme de VARCHAR; adapte la longueur si tu veux
        $column['length'] = $column['length'] ?? 63;
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }
        if (!$value instanceof DateRange) {
            throw new \InvalidArgumentException('$value should be an instance of App\\DateRange or null.');
        }

        // Exemple : "1704067200-1735689600"
        return sprintf(
            '%u-%u',
            $value->getFrom()->getTimestamp(),
            $value->getTo()->getTimestamp()
        );
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?DateRange
    {
        if ($value === null || $value === '') {
            return null;
        }

        sscanf($value, '%u-%u', $from, $to);

        return new DateRange(
            (new \DateTimeImmutable())->setTimestamp($from),
            (new \DateTimeImmutable())->setTimestamp($to),
        );
    }

    // Important pour que SchemaTool/Migrations conservent le type custom
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}

