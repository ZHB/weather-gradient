<?php

/*
 * This file is part of the Weather Gradient package.
 *
 * (c) Vincent Huck <vincent.huck.pro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zhb\WeatherGradient;

class Contrast
{
    /**
     * Determines the brightness contrast ratio between a background and a foreground color.
     */
    private static function brightnessContrastRatio(array $backgroundColor, array $foregroundColor): string
    {
        list($r1, $g1, $b1) = $backgroundColor;
        list($r2, $g2, $b2) = $foregroundColor;

        $l1 = 0.2126 * (($r1 / 255) ** 2.2) + 0.7152 * (($g1 / 255) ** 2.2) + 0.0722 * (($b1 / 255) ** 2.2);
        $l2 = 0.2126 * (($r2 / 255) ** 2.2) + 0.7152 * (($g2 / 255) ** 2.2) + 0.0722 * (($b2 / 255) ** 2.2);

        if ($l1 > $l2) {
            $ratio = ($l1 + 0.05) / ($l2 + 0.05);
        } else {
            $ratio = ($l2 + 0.05) / ($l1 + 0.05);
        }

        return $ratio;
    }

    /**
     * Return black or white hexadecimal color that fit best (best contrast ratio) with a given background color.
     */
    public static function darkOrLight(array $backgroundColor, array $color1 = [255, 255, 255], array $color2 = [0, 0, 0], int $ratioBreak = 5): string
    {
        $ratio = self::brightnessContrastRatio($backgroundColor, $color2);

        $preferredColor = $ratio < $ratioBreak ? $color1 : $color2;

        return implode(',', $preferredColor);
    }
}
