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
use Zhb\WeatherGradient\Gradient;

class GradientTest extends TestCase
{
    /**
     * @dataProvider invalidColorNumberProvider
     */
    public function testInvalidColorNumber(array $colors)
    {
        $this->expectExceptionMessage('Gradient colors must contain at least two RGB colors.');

        new Gradient($colors);
    }

    public function invalidColorNumberProvider(): \Generator
    {
        yield [[]];
        yield [[10 => [0, 0, 0]]];
    }

    /**
     * @dataProvider invalidColorKeysProvider
     */
    public function testInvalidColorKeys(array $colors)
    {
        $this->expectExceptionMessage('Colors must be an associative array with numeric keys only.');

        new Gradient($colors);
    }

    public function invalidColorKeysProvider(): \Generator
    {
        // invalid string keys
        yield [[
            'a' => [0, 0, 0],
            'b' => [255, 255, 255],
        ]];

        // missing associative keys
        yield [[
            [0, 0, 0],
            [255, 255, 255],
        ]];
    }

    /**
     * @dataProvider expectedColorAtPositionForTwoColorsThresholdProvider
     */
    public function testExpectedColorAtPositionForTwoColorsThreshold(int $position, array $expectedColor)
    {
        $colors = [
            10 => [0, 0, 0],
            20 => [255, 255, 255],
        ];

        $gradient = new Gradient($colors);
        $color = $gradient->colorAtGradientPosition($position);

        $this->assertSame($expectedColor, $color->getRGB());
    }

    public function expectedColorAtPositionForTwoColorsThresholdProvider(): \Generator
    {
        yield [9, [0, 0, 0]]; // out of boundaries

        yield [10, [0, 0, 0]];
        yield [11, [25, 25, 25]];
        yield [12, [51, 51, 51]];
        yield [13, [76, 76, 76]];
        yield [14, [102, 102, 102]];
        yield [15, [127, 127, 127]];
        yield [16, [153, 153, 153]];
        yield [17, [178, 178, 178]];
        yield [18, [204, 204, 204]];
        yield [19, [229, 229, 229]];
        yield [20, [255, 255, 255]];

        yield [21, [255, 255, 255]]; // out of boundaries
    }

    /**
     * @dataProvider expectedColorAtPositionForMultipleColorsThresholdProvider
     */
    public function testExpectedColorAtPositionForMultipleColorsThreshold(int $position, array $expectedColor)
    {
        $colors = [
            -20 => [37, 99, 235], //2563EB
            1 => [236, 253, 245], //ECFDF5
            15 => [16, 185, 129], //10B981
            30 => [220, 38, 38], //DC2626
        ];

        $gradient = new Gradient($colors);
        $color = $gradient->colorAtGradientPosition($position);

        $this->assertSame($expectedColor, $color->getRGB());
    }

    /**
     * @dataProvider expectedColorAtPositionForMultipleColorsThresholdProvider
     */
    public function testExpectedColorAtPositionForUnorderedColors(int $position, array $expectedColor)
    {
        $colors = [
            30 => [220, 38, 38],
            -20 => [37, 99, 235],
            15 => [16, 185, 129],
            1 => [236, 253, 245],
        ];

        $gradient = new Gradient($colors);
        $color = $gradient->colorAtGradientPosition($position);

        $this->assertSame($expectedColor, $color->getRGB());
    }

    public function expectedColorAtPositionForMultipleColorsThresholdProvider(): \Generator
    {
        yield [-30, [37, 99, 235]]; // out of boundaries
        yield [-20, [37, 99, 235]]; // threshold
        yield [-10, [131, 172, 239]];
        yield [1, [236, 253, 245]]; // threshold
        yield [5, [173, 233, 211]];
        yield [15, [16, 185, 129]]; // threshold
        yield [23, [124, 106, 80]];
        yield [30, [220, 38, 38]]; // threshold
        yield [40, [220, 38, 38]]; // out of boundaries
    }
}
