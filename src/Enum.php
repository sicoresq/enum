<?php

namespace Sicoresq\Enum;

use JsonSerializable;
use ReflectionClass;
use UnexpectedValueException;
use function constant;
use function gettype;
use function in_array;
use function is_scalar;
use function sprintf;

abstract class Enum implements JsonSerializable
{
    protected $value;

    private static $constList;

    public static function tryFrom($value): ?static
    {
        return static::hasValue($value) ? new static($value) : null;
    }

    public static function from($value): static
    {
        return new static($value);
    }

    public static function hasValue($value): bool
    {
        $availableValues = static::getConstList();

        return in_array($value, $availableValues, true);
    }

    /**
     * @return static[]
     */
    public static function getAll(): array
    {
        $out = [];
        foreach (static::getConstList() as $const) {
            $out[] = new static($const);
        }

        return $out;
    }

    public static function getConstList(): array
    {
        if (!empty(self::$constList[static::class])) {
            return self::$constList[static::class];
        }

        $reflectionClass = new ReflectionClass(static::class);
        self::$constList[static::class] = $reflectionClass->getConstants();

        return self::$constList[static::class];
    }

    /**
     * @param $name
     * @param $arguments
     * @return static
     */
    public static function __callStatic($name, $arguments): self
    {
        return new static(constant('static::' . $name));
    }

    public function __construct($value)
    {
        $availableValues = static::getConstList();

        if (!is_scalar($value)) {
            throw new UnexpectedValueException(sprintf('Unexpected value type: "%s" for enum %s', gettype($value), static::class));
        }

        if (!in_array($value, $availableValues, true)) {
            throw new UnexpectedValueException(sprintf('Unexpected value: "%s" for enum %s', $value, static::class));
        }

        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function equals(...$anyOther): bool
    {
        foreach ($anyOther as $other) {
            if ((string)$this === (string)$other) {
                return true;
            }
        }
        return false;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }

    public function jsonSerialize(): mixed
    {
        return $this->value;
    }
}
