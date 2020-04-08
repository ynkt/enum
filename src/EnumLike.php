<?php
declare(strict_types=1);

/**
 * @license MIT
 * @copyright 2020 Nakata Yudai
 * @link https://github.com/ynkt/enum-like
 * @author ynkt
 */

namespace Ynkt\EnumLike;

use ReflectionClass;

/**
 * Class EnumLike
 *
 * @package Ynkt\EnumLike
 */
abstract class EnumLike
{
    /**
     * Stores created instances per Enum class
     *
     * @var EnumLike[][]
     */
    private static $instances;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $ordinal;

    /**
     * @return string
     */
    final public function name(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    final public function ordinal(): int
    {
        return $this->ordinal;
    }

    /**
     * @return string
     */
    final public function declaringClass(): string
    {
        return get_class($this);
    }

    /**
     * Tests enum instances are equal
     *
     * @param EnumLike $instance
     *
     * @return bool
     */
    public function equals(EnumLike $instance): bool
    {
        return $this->declaringClass() === $instance->declaringClass() && $this->name() === $instance->name();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%s::%s', $this->declaringClass(), $this->name());
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::byName($name);
    }

    /**
     * Gets an instance by the name of the enumerations
     *
     * @param string $name
     *
     * @return static
     */
    private static function byName(string $name): ?EnumLike
    {
        $expression = function (self $instance) use ($name) { return $name === $instance->name(); };

        if (! self::has($expression)) {
            throw (new EnumeratorNotFoundException())->setQueryParameter(static::class, compact('name'));
        }

        return self::first($expression);
    }

    /**
     * Gets the first instance that passes a given truth
     *
     * @param callable|null $closure
     *
     * @return static|null
     */
    final public static function first(callable $closure = null): ?EnumLike
    {
        foreach (self::getInstances(static::class) as $instance) {
            if (is_null($closure) || $closure($instance)) {
                return $instance;
            }
        }

        return null;
    }

    /**
     * Is exists an enumerator that passes a given truth
     *
     * @param callable $closure
     *
     * @return bool
     */
    final public static function has(callable $closure): bool
    {
        return ! is_null(self::first($closure));
    }

    /**
     * Gets instances of the Enum class of all Enum constants
     *
     * @return static[]
     */
    final public static function values(): array
    {
        return self::getInstances(static::class);
    }

    /**
     * Gets instances of the given Enum class from cache
     *
     * @param string $class
     *
     * @return array
     */
    private static function getInstances(string $class): array
    {
        if (! isset(self::$instances[$class])) {
            self::cacheInstances($class);
        }

        return self::$instances[$class];
    }

    /**
     * Stores instances of the given Enum class
     *
     * @param string $class
     */
    private static function cacheInstances(string $class): void
    {
        self::$instances[$class] = self::createInstances($class);
    }

    /**
     * Creates instances of the given Enum class
     *
     * @param string $class
     *
     * @return EnumLike[]
     */
    private static function createInstances(string $class): array
    {
        $constants = [];
        $ordinalCounter = 0;
        foreach (static::getConstants($class) as $name => $values) {
            $constants[] = static::buildInstance($class, $name, $ordinalCounter, $values);
            $ordinalCounter++;
        }

        return $constants;
    }

    /**
     * Gets constants of the given Enum class
     *
     * @param string $class
     *
     * @return array
     */
    protected static function getConstants(string $class)
    {
        return (new ReflectionClass($class))->getConstants();
    }

    /**
     * Builds an instance
     *
     * @param string $class
     * @param string $name
     * @param int $ordinal
     * @param mixed $values
     *
     * @return EnumLike
     */
    private static function buildInstance(string $class, string $name, int $ordinal, $values): EnumLike
    {
        $instance = static::createInstance($class, $values);
        $instance->initializeFoundationalProperties($name, $ordinal);

        return $instance;
    }

    /**
     * Creates an instance
     *
     * @param string $class
     * @param mixed $values
     *
     * @return EnumLike
     */
    protected static function createInstance(string $class, $values): EnumLike
    {
        return is_array($values) ? new $class(...$values) : new $class($values);
    }

    /**
     * Initialize properties of the this class
     *
     * @param string $name
     * @param int $ordinal
     */
    private function initializeFoundationalProperties(string $name, int $ordinal): void
    {
        $this->name = $name;
        $this->ordinal = $ordinal;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed|void
     */
    public function __call($name, $arguments)
    {
        return static::__callStatic($name, $arguments);
    }
}
