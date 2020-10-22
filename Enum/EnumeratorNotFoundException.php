<?php

declare(strict_types=1);

/**
 * @license MIT
 * @copyright 2020 Nakata Yudai
 * @link https://github.com/ynkt/enum
 * @author ynkt
 */

namespace Ynkt\Enum;

use RuntimeException;

/**
 * Class EnumeratorNotFoundException
 *
 * @package Ynkt\Enum
 */
class EnumeratorNotFoundException extends RuntimeException
{
    /**
     * @param string $enum
     * @param array $parameter
     *
     * @return $this
     */
    public function setQueryParameter(string $enum, array $parameter): self
    {
        foreach ($parameter as $key => $value) {
            $this->message = sprintf('No results for [%s] with %s=%s.', $enum, $key, $value);
            break;
        }

        return $this;
    }
}
