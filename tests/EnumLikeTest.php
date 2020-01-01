<?php
declare(strict_types=1);

/**
 * @license MIT
 * @copyright 2020 Nakata Yudai
 * @link https://github.com/ynkt/enum-like
 * @author ynkt
 */

namespace Ynkt\Tests\EnumLike;

use PHPUnit\Framework\TestCase;
use Ynkt\Tests\EnumLike\Fixtures\DayOfWeek;
use Ynkt\Tests\EnumLike\Fixtures\Color;
use Ynkt\Tests\EnumLike\Fixtures\RepositoryColor;

/**
 * Class EnumLikeTest
 *
 * @package Ynkt\Tests\EnumLike
 */
class EnumLikeTest extends TestCase
{
    /**
     * @test
     */
    public function values()
    {
        $this->assertCount(7, DayOfWeek::values());

        $this->assertCount(3, Color::values());

        $this->assertCount(3, RepositoryColor::values());
    }

    /**
     * @test
     */
    public function name()
    {
        $this->assertEquals('MONDAY', DayOfWeek::MONDAY()->name());
        $this->assertEquals('SATURDAY', DayOfWeek::SATURDAY()->name());

        $this->assertEquals('RED', Color::RED()->name());

        $this->assertEquals('RED', RepositoryColor::RED()->name());
    }

    /**
     * @test
     */
    public function ordinal()
    {
        $this->assertEquals(1, DayOfWeek::TUESDAY()->ordinal());
        $this->assertEquals(6, DayOfWeek::SUNDAY()->ordinal());

        $this->assertEquals(0, Color::RED()->ordinal());

        $this->assertEquals(0, RepositoryColor::RED()->ordinal());
    }

    /**
     * @test
     */
    public function declaringClass()
    {
        $this->assertEquals(DayOfWeek::class, DayOfWeek::TUESDAY()->declaringClass());

        $this->assertEquals(Color::class, Color::BLACK()->declaringClass());

        $this->assertEquals(RepositoryColor::class, RepositoryColor::BLACK()->declaringClass());
    }

    /**
     * @test
     */
    public function valueOf()
    {
        $sut = DayOfWeek::SATURDAY();
        $this->assertTrue($sut->valueOf(DayOfWeek::SATURDAY()));
        $this->assertFalse($sut->valueOf(DayOfWeek::TUESDAY()));

        $sut = Color::BLUE();
        $this->assertTrue($sut->valueOf(Color::BLUE()));
        $this->assertFalse($sut->valueOf(Color::RED()));

        $sut = RepositoryColor::BLUE();
        $this->assertTrue($sut->valueOf(RepositoryColor::BLUE()));
        $this->assertFalse($sut->valueOf(RepositoryColor::RED()));
    }

    /**
     * @test
     */
    public function dayOfWeek_isWeekEnd()
    {
        $this->assertTrue(DayOfWeek::SUNDAY()->isWeekEnd());
        $this->assertFalse(DayOfWeek::WEDNESDAY()->isWeekEnd());
    }

    /**
     * @test
     */
    public function dayOfWeek_byId()
    {
        $this->assertEquals(DayOfWeek::THURSDAY(), DayOfWeek::byId(4));
    }

    /**
     * @test
     */
    public function color_code()
    {
        $this->assertEquals('#FF0000', Color::RED()->code());

        $this->assertEquals('#FF0000', RepositoryColor::RED()->code());
    }

    /**
     * @test
     */
    public function color_rgb()
    {
        $this->assertEquals([0, 0, 0], Color::BLACK()->rgb());

        $this->assertEquals([0, 0, 0], RepositoryColor::BLACK()->rgb());
    }
}
