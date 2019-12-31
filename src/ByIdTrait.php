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
     * @return int
     */
    abstract protected function id(): int;

    /**
     * @param int $id
     *
     * @return static
     */
    public static function byId(int $id)
    {
        return self::first(function (self $instance) use ($id) {
            return $id == $instance->id();
        });
    }
}
