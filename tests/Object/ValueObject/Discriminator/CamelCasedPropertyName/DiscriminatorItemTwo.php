<?php

declare(strict_types=1);

namespace ADS\JsonImmutableObjects\Tests\Object\ValueObject\Discriminator\CamelCasedPropertyName;

use ADS\JsonImmutableObjects\JsonSchemaAwareRecordLogic;
use EventEngine\JsonSchema\JsonSchemaAwareRecord;

class DiscriminatorItemTwo implements JsonSchemaAwareRecord
{
    use JsonSchemaAwareRecordLogic;

    private TypeVo $myType;
    private int $other;
}
