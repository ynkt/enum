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
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function ordinal(): int
    {
        return $this->ordinal;
    }

    /**
     * @return string
     */
    public function declaringClass(): string
    {
        return get_class($this);
    }

    /**
     * @param EnumLike $instance
     *
     * @return bool
     */
    public function valueOf(EnumLike $instance): bool
    {
        return get_class($this) === get_class($instance) && $this->name() === $instance->name();
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
     * @param string $name
     *
     * @return static|null
     */
    private static function byName(string $name): ?EnumLike
    {
        return self::first(function (EnumLike $instance) use ($name) {
            return $name === $instance->name();
        });
    }

    /**
     * @param callable|null $closure
     *
     * @return static|null
     */
    protected static function first(callable $closure = null): ?EnumLike
    {
        foreach (self::getInstances(static::class) as $instance) {
            if (is_null($closure) || $closure($instance)) {
                return $instance;
            }
        }

        return null;
    }

    /**
     * @return static[]
     */
    public static function values(): array
    {
        return self::getInstances(static::class);
    }

    /**
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
     * @param string $class
     */
    private static function cacheInstances(string $class): void
    {
        self::$instances[$class] = self::createInstances($class);
    }

    /**
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
     * @param string $class
     *
     * @return array
     * @noinspection PhpDocMissingThrowsInspection
     */
    protected static function getConstants(string $class)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return (new ReflectionClass($class))->getConstants();
    }

    /**
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

        /** @noinspection PhpUndefinedMethodInspection */
        $instance->initializeNameAttribute($name);
        /** @noinspection PhpUndefinedMethodInspection */
        $instance->initializeOrdinalAttribute($ordinal);

        return $instance;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed|void
     */
    public function __call($name, $arguments)
    {
        if ($name === 'initializeNameAttribute') {
            $this->name = $arguments[0];
            return;
        }

        if ($name === 'initializeOrdinalAttribute') {
            $this->ordinal = $arguments[0];
            return;
        }

        return static::__callStatic($name, $arguments);
    }

    /**
     * @param string $class
     * @param mixed $values
     *
     * @return EnumLike
     */
    protected static function createInstance(string $class, $values): EnumLike
    {
        return is_array($values) ? new $class(...$values) : new $class($values);
    }
}
