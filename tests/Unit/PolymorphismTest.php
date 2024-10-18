<?php

declare(strict_types=1);

namespace ADS\JsonImmutableObjects\Tests\Unit;

use ADS\JsonImmutableObjects\Tests\Object\OneOfWithDiscriminator;
use ADS\JsonImmutableObjects\Tests\Object\OneOfWithDiscriminatorOne;
use ADS\JsonImmutableObjects\Tests\Object\OneOfWithDiscriminatorTwo;
use ADS\JsonImmutableObjects\Tests\Object\OneOfWithInvalidClass;
use ADS\JsonImmutableObjects\Tests\Object\OneOfWithInvalidClassType;
use ADS\JsonImmutableObjects\Tests\Object\TypeVO;
use ADS\JsonImmutableObjects\Tests\Object\ValueObject\Discriminator\CamelCasedPropertyName\DiscriminatorItemOne;
// phpcs:ignore Generic.Files.LineLength.TooLong
use ADS\JsonImmutableObjects\Tests\Object\ValueObject\Discriminator\CamelCasedPropertyName\OneOfWithCamelCasedDiscriminator;
use EventEngine\JsonSchema\Type\UnionType;
use PHPUnit\Framework\TestCase;

class PolymorphismTest extends TestCase
{
    private function discriminatorObject(): OneOfWithDiscriminator
    {
        return OneOfWithDiscriminator::fromArray(
            [
                'type' => 'OneOfWithDiscriminatorOne',
                'value' => 10,
            ],
        );
    }

    public function testWithNativeData(): void
    {
        $test = $this->discriminatorObject();

        $this->assertInstanceOf(OneOfWithDiscriminator::class, $test);
        $this->assertInstanceOf(OneOfWithDiscriminatorOne::class, $test->value());
        $this->assertIsArray($test->toArray());
    }

    public function testWith(): void
    {
        $test = $this->discriminatorObject();

        $newTest = $test->with(
            ['value' => 20],
        );

        $one = $test->value();
        $oneNew = $newTest->value();
        $this->assertInstanceOf(OneOfWithDiscriminatorOne::class, $one);
        $this->assertInstanceOf(OneOfWithDiscriminatorOne::class, $oneNew);
        $this->assertEquals(10, $one->value());
        $this->assertEquals(20, $oneNew->value());
    }

    public function testWithRecordData(): void
    {
        $test = OneOfWithDiscriminator::fromRecordData(
            [
                'type' => TypeVO::fromString('OneOfWithDiscriminatorTwo'),
                'other' => 'test',
            ],
        );

        $this->assertInstanceOf(OneOfWithDiscriminator::class, $test);
        $this->assertInstanceOf(OneOfWithDiscriminatorTwo::class, $test->value());
    }

    public function testCompare(): void
    {
        $test = $this->discriminatorObject();
        $notEqual = OneOfWithDiscriminator::fromRecordData(
            [
                'type' => TypeVO::fromString('OneOfWithDiscriminatorTwo'),
                'other' => 'test',
            ],
        );

        $this->assertTrue($test->equals($test));
        $this->assertTrue($test->equals($test->value()));
        $this->assertFalse($test->equals($notEqual));
    }

    public function testSchema(): void
    {
        $schema = OneOfWithDiscriminator::__schema();

        $this->assertInstanceOf(UnionType::class, $schema);
        $this->assertIsArray($schema->toArray());
    }

    public function testPolymorphismWithoutCorrectDiscriminator(): void
    {
        $this->expectExceptionMessageMatches('/No discriminator property/');
        OneOfWithDiscriminator::fromArray(
            [
                'bla' => 'one',
                'value' => 10,
            ],
        );
    }

    public function testPolymorphismWithInvalidDiscriminatorType(): void
    {
        $this->expectExceptionMessageMatches('/needs to be a string as a discriminator/');
        OneOfWithDiscriminator::fromArray(
            [
                'type' => 1,
                'value' => 10,
            ],
        );
    }

    public function testPolymorphismWithInvalidDiscriminatorValue(): void
    {
        $this->expectExceptionMessageMatches('/Discriminator value \'.+\' is not valid for/');
        OneOfWithDiscriminator::fromArray(
            [
                'type' => 'three',
                'value' => 10,
            ],
        );
    }

    public function testPolymorphismWithInvalidDiscriminatorClass(): void
    {
        $this->expectExceptionMessageMatches(
            '/Class \'.+\' doesn\'t exists as oneOf model for discriminator/',
        );

        OneOfWithInvalidClass::fromArray(
            [
                'type' => 'one',
                'value' => 10,
            ],
        );
    }

    public function testPolymorphismWithInvalidDiscriminatorClassType(): void
    {
        $this->expectExceptionMessageMatches(
            '/Class \'.+\' should be an implementation of/',
        );

        OneOfWithInvalidClassType::fromArray(
            [
                'type' => 'one',
                'value' => 10,
            ],
        );
    }

    public function testWithType(): void
    {
        $test = $this->discriminatorObject();

        $this->expectExceptionMessageMatches(
            '/Can\'t set the discriminator property as a key in the with function/',
        );

        $test->with(
            [
                'type' => 'OneOfWithDiscriminatorTwo',
                'other' => 'test2',
            ],
        );
    }

    public function testDiscriminatorWithCamelCasedPropertyName(): void
    {
        $object = OneOfWithCamelCasedDiscriminator::fromArray(
            [
                'my_type' => 'one',
                'other' => 'oh-my',
            ],
        );

        $this->assertInstanceOf(OneOfWithCamelCasedDiscriminator::class, $object);
        $this->assertInstanceOf(DiscriminatorItemOne::class, $object->value());
    }
}
