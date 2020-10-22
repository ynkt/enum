<?php

declare(strict_types=1);

/**
 * @license MIT
 * @copyright 2020 Nakata Yudai
 * @link https://github.com/ynkt/enum
 * @author ynkt
 */

namespace Ynkt\Tests\Enum\Fixtures;

use Ynkt\Enum\Enum;

/**
 * Class Status
 */
class Status extends Enum
{
    private const READY = 'Ready';
    private const IN_PROGRESS = 'In Progress';
    private const DONE = 'Done';

    private string $text;

    protected function __construct(string $text)
    {
        $this->text = $text;
    }

    public function text(): string { return $this->text; }
}
