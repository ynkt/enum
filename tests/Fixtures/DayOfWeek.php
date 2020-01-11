<?php
declare(strict_types=1);

/**
 * @license MIT
 * @copyright 2020 Nakata Yudai
 * @link https://github.com/ynkt/enum-like
 * @author ynkt
 */

namespace Ynkt\Tests\EnumLike\Fixtures;

use Ynkt\EnumLike\ByIdTrait;
use Ynkt\EnumLike\EnumLike;

/**
 * Class DayOfWeek
 *
 * @package Ynkt\Tests\EnumLike\Fixtures
 *
 * @method static self MONDAY()
 * @method static self TUESDAY()
 * @method static self WEDNESDAY()
 * @method static self THURSDAY()
 * @method static self FRIDAY()
 * @method static self SATURDAY()
 * @method static self SUNDAY()
 */
class DayOfWeek extends EnumLike
{
    use ByIdTrait;

    private const MONDAY = 1;
    private const TUESDAY = 2;
    private const WEDNESDAY = 3;
    private const THURSDAY = 4;
    private const FRIDAY = 5;
    private const SATURDAY = 6;
    private const SUNDAY = 7;

    /**
     * @var int
     */
    private $id;

    /**
     * DayOfWeek constructor.
     *
     * @param int $id
     */
    protected function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function isWeekEnd(): bool
    {
        return $this->equals(self::SATURDAY()) || $this->equals(self::SUNDAY());
    }

    /**
     * @return string|int
     */
    public function id()
    {
        return $this->id;
    }
}
