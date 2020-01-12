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
use Ynkt\EnumLike\NotFoundException;
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
    public function getInstance_whenMethodNameExists()
    {
        $this->assertInstanceOf(DayOfWeek::class, DayOfWeek::MONDAY());

        $this->assertInstanceOf(Color::class, Color::RED());

        $this->assertInstanceOf(RepositoryColor::class, RepositoryColor::RED());
    }

    /**
     * @test
     */
    public function getInstance_whenMethodNameDoesNotExist()
    {
        $this->expectException(NotFoundException::class);
        DayOfWeek::FOO();
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
    public function equals()
    {
        $sut = DayOfWeek::SATURDAY();
        $this->assertTrue($sut->equals(DayOfWeek::SATURDAY()));
        $this->assertFalse($sut->equals(DayOfWeek::TUESDAY()));

        $sut = Color::BLUE();
        $this->assertTrue($sut->equals(Color::BLUE()));
        $this->assertFalse($sut->equals(Color::RED()));

        $sut = RepositoryColor::BLUE();
        $this->assertTrue($sut->equals(RepositoryColor::BLUE()));
        $this->assertFalse($sut->equals(RepositoryColor::RED()));
    }

    /**
     * @test
     */
    public function test_toString()
    {
        $sut = DayOfWeek::MONDAY();
        $this->assertEquals(sprintf('%s::%s', DayOfWeek::class, $sut->name()), (string)$sut);

        $sut = Color::RED();
        $this->assertEquals(sprintf('%s::%s', Color::class, $sut->name()), (string)$sut);

        $sut = RepositoryColor::RED();
        $this->assertEquals(sprintf('%s::%s', RepositoryColor::class, $sut->name()), (string)$sut);
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
    public function dayOfWeek_byId_whenGivenIdExists()
    {
        $this->assertEquals(DayOfWeek::THURSDAY(), DayOfWeek::byId(4));
    }

    /**
     * @test
     */
    public function dayOfWeek_byId_whenGivenIdDoesNotExist()
    {
        $this->expectException(NotFoundException::class);
        DayOfWeek::byId(-1);
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
