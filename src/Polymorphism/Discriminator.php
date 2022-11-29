<?php

declare(strict_types=1);

namespace ADS\JsonImmutableObjects\Polymorphism;

use EventEngine\JsonSchema\JsonSchemaAwareRecord;

interface Discriminator extends JsonSchemaAwareRecord
{
    public static function propertyName(): string;

    /**
     * @return array<string, class-string<JsonSchemaAwareRecord>>
     */
    public static function mapping(): array;

    /**
     * @return array<class-string<JsonSchemaAwareRecord>>
     */
    public static function jsonSchemaAwareRecords(): array;
}