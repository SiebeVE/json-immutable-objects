<?php

declare(strict_types=1);

namespace ADS\JsonImmutableObjects\Tests\Object\ValueObject\Discriminator\CamelCasedPropertyName;

use ADS\JsonImmutableObjects\Polymorphism\Discriminator;
use ADS\JsonImmutableObjects\Polymorphism\DiscriminatorLogic;

class OneOfWithCamelCasedDiscriminator implements Discriminator
{
    use DiscriminatorLogic;

    public static function propertyName(): string
    {
        return 'myType';
    }

    /** @inheritDoc */
    public static function jsonSchemaAwareRecords(): array
    {
        return [
            DiscriminatorItemOne::class,
            DiscriminatorItemTwo::class,
        ];
    }

    /** @return array<string, string> */
    public static function mapping(): array
    {
        return [
            TypeVo::ONE => DiscriminatorItemOne::class,
            TypeVo::TWO => DiscriminatorItemTwo::class,
        ];
    }
}
