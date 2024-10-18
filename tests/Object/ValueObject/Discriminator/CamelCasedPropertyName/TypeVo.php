<?php

declare(strict_types=1);

namespace ADS\JsonImmutableObjects\Tests\Object\ValueObject\Discriminator\CamelCasedPropertyName;

use ADS\ValueObjects\Implementation\Enum\StringEnumValue;

class TypeVo extends StringEnumValue
{
    public const ONE = 'one';
    public const TWO = 'two';

    /** @return string[] */
    public static function possibleValues(): array
    {
        return [
            self::ONE,
            self::TWO,
        ];
    }
}
