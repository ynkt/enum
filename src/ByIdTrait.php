<?php
declare(strict_types=1);

/**
 * @license MIT
 * @copyright 2020 Nakata Yudai
 * @link https://github.com/ynkt/enum-like
 * @author ynkt
 */

namespace Ynkt\EnumLike;

/**
 * Trait ByIdTrait
 *
 * @package Ynkt\EnumLike
 */
trait ByIdTrait
{
    /**
     * @return string|int
     */
    abstract protected function id();

    /**
     * @param string|int $id
     *
     * @return static
     */
    public static function byId($id)
    {
        $instance = self::first(function (self $instance) use ($id) {
            return $id == $instance->id();
        });

        if (is_null($instance)) {
            throw new NotFoundException(
                sprintf('An enumerator with ID:[%s] does not exist in the %s.', $id, static::class)
            );
        }

        return $instance;
    }
}
