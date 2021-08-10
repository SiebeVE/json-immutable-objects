<?php

declare(strict_types=1);

namespace ADS\JsonImmutableObjects;

use function array_keys;

trait DefaultsAreNotRequired
{
    use JsonSchemaAwareRecordLogic;

    /**
     * @return array<string>
     *
     * @inheritDoc
     */
    private static function __optionalProperties(): array
    {
        return array_keys(self::defaultProperties());
    }
}
