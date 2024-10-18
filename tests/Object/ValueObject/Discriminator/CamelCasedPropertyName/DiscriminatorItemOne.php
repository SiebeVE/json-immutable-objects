<?php

declare(strict_types=1);

namespace ADS\JsonImmutableObjects\Tests\Object\ValueObject\Discriminator\CamelCasedPropertyName;

use ADS\JsonImmutableObjects\JsonSchemaAwareRecordLogic;
use EventEngine\JsonSchema\JsonSchemaAwareRecord;

class DiscriminatorItemOne implements JsonSchemaAwareRecord
{
    use JsonSchemaAwareRecordLogic;

    private TypeVo $myType;
    private string $other;
}
