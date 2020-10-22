<?php

declare(strict_types=1);

/**
 * @license MIT
 * @copyright 2020 Nakata Yudai
 * @link https://github.com/ynkt/enum-like
 * @author ynkt
 */

namespace Ynkt\Tests\EnumLike\Fixtures;

use Ynkt\EnumLike\EnumLike;

/**
 * Class Color
 *
 * @package Ynkt\Tests\EnumLike\Fixtures
 *
 * @method static self RED()
 * @method static self BLUE()
 * @method static self BLACK()
 */
class Color extends EnumLike
{
    private const RED = ['#FF0000', [255, 0, 0]];
    private const BLUE = ['#0000FF', [0, 0, 255]];
    private const BLACK = ['#000000', [0, 0, 0]];

    private string $code;
    /**
     * @var int[]
     */
    private array $rgb;

    /**
     * Color constructor.
     *
     * @param string $code
     * @param int[] $rgb
     */
    protected function __construct(string $code, array $rgb)
    {
        $this->code = $code;
        $this->rgb = $rgb;
    }

    public function code(): string { return $this->code; }

    public function rgb(): array { return $this->rgb; }
}
