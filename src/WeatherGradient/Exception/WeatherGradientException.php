<?php

/*
 * This file is part of the Weather Gradient package.
 *
 * (c) Vincent Huck <vincent.huck.pro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zhb\WeatherGradient\Exception;

use Throwable;

class WeatherGradientException extends \Exception
{
    public static function missingOrInvalidNumberOfColors(Throwable $previous = null): self
    {
        return new self('Gradient colors must contain at least two RGB colors.', 0, $previous);
    }

    public static function arrayColorsNotValid(Throwable $previous = null): self
    {
        return new self('Colors must be an associative array with numeric keys only.', 0, $previous);
    }
}
