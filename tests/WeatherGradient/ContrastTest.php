<?php

/*
 * This file is part of the Weather Gradient package.
 *
 * (c) Vincent Huck <vincent.huck.pro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WeatherGradient;

use PHPUnit\Framework\TestCase;
use Zhb\WeatherGradient\Contrast;

class ContrastTest extends TestCase
{
    /**
     * @dataProvider colorsProvider
     */
    public function testPreferredColorBetweenBlackOrWhite(array $backgroundColor, string $expectedColor): void
    {
        $blackOrWhite = Contrast::darkOrLight($backgroundColor);

        self::assertSame($expectedColor, $blackOrWhite);
    }

    public function colorsProvider(): \Generator
    {
        yield [[0, 0, 0], '255,255,255']; // Black
        yield [[255, 255, 255], '0,0,0']; // White
        yield [[128, 128, 128], '0,0,0']; // Gray/Grey
        yield [[220, 220, 220], '0,0,0']; // Gainsboro
        yield [[211, 211, 211], '0,0,0']; // Light gray
        yield [[192, 192, 192], '0,0,0']; // Silver
        yield [[190, 190, 190], '0,0,0']; // Medium Gray
        yield [[152, 152, 152], '0,0,0']; // Spanish Gray
        yield [[105, 105, 105], '255,255,255']; // Dim Gray
        yield [[85, 85, 85], '255,255,255']; // Davy's gray
        yield [[52, 52, 52], '255,255,255']; // Jet

    }
}