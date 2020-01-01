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
 * Class RepositoryColor
 *
 * @package Ynkt\Tests\EnumLike\Fixtures
 *
 * @method static self RED()
 * @method static self BLUE()
 * @method static self BLACK()
 */
class RepositoryColor extends EnumLike
{
    /**
     * @param string $class
     *
     * @return array
     */
    protected static function getConstants(string $class): array
    {
        return [
            'RED'   => ['#FF0000', [255, 0, 0]],
            'BLUE'  => ['#0000FF', [0, 0, 255]],
            'BLACK' => ['#000000', [0, 0, 0]],
        ];
    }

    /**
     * @var string
     */
    private $code;
    /**
     * @var int[]
     */
    private $rgb;

    /**
     * RepositoryColor constructor.
     *
     * @param string $code
     * @param int[] $rgb
     */
    protected function __construct(string $code, array $rgb)
    {
        $this->code = $code;
        $this->rgb = $rgb;
    }

    /**
     * @return string
     */
    public function code(): string
    {
        return $this->code;
    }

    /**
     * @return int[]
     */
    public function rgb(): array
    {
        return $this->rgb;
    }
}
