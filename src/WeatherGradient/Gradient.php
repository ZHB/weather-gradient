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

use Zhb\WeatherGradient\Exception\WeatherGradientException;

class Gradient
{
    private array $rgbColors = [];

    public function __construct(array $colors)
    {
        $this->rgbColors = $colors;

        if (2 > $this->countColors()) {
            throw WeatherGradientException::missingOrInvalidNumberOfColors();
        }

        if (!$this->isColorsValid($colors)) {
            throw WeatherGradientException::arrayColorsNotValid();
        }

        ksort($this->rgbColors);
    }

    private function getRgbColors(): array
    {
        return array_values($this->rgbColors);
    }

    private function getThresholds(): array
    {
        return array_keys($this->rgbColors);
    }

    private function countColors(): int
    {
        return \count($this->rgbColors);
    }

    private function isColorsValid(array $array): bool
    {
        if ([] === $array) {
            return false;
        }

        $keys = $this->getThresholds();

        // numeric keys only
        if ($keys !== array_filter($keys, 'is_int')) {
            return false;
        }

        return $keys !== range(0, \count($array) - 1);
    }

    /**
     * Retrieves the color at the given position of the gradient.
     */
    public function colorAtGradientPosition(int $position): RgbColor
    {
        $gradientThresholds = $this->getThresholds();
        $gradientRgbs = $this->getRgbColors();
        $colorCount = $this->countColors();

        $rgbColor = [];
        for ($i = 0; $i < $colorCount; ++$i) {
            if ($position >= $gradientThresholds[$i] && $position < ($gradientThresholds[$i + 1] ?? $gradientThresholds[$i])) {
                $rgb1 = $gradientRgbs[$i];
                $rgb2 = $gradientRgbs[$i + 1];

                for ($j = 0; $j < 3; ++$j) {
                    $c = (max($rgb1[$j], $rgb2[$j]) - min($rgb1[$j], $rgb2[$j])) / (max($gradientThresholds[$i], $gradientThresholds[$i + 1]) - min($gradientThresholds[$i], $gradientThresholds[$i + 1]));

                    if ($rgb1[$j] < $rgb2[$j]) {
                        $rgbColor[] = (int) (max($rgb1[$j], $rgb2[$j]) - ((max($gradientThresholds[$i], $gradientThresholds[$i + 1]) - $position) * $c));
                    } else {
                        $rgbColor[] = (int) (min($rgb1[$j], $rgb2[$j]) + ((max($gradientThresholds[$i], $gradientThresholds[$i + 1]) - $position) * $c));
                    }
                }
            }
        }

        if ($position <= $gradientThresholds[0]) {
            $rgbColor = $gradientRgbs[0];
        }

        if ($position >= $gradientThresholds[$colorCount - 1]) {
            $rgbColor = $gradientRgbs[$colorCount - 1];
        }

        return RgbColor::fromRgb($rgbColor);
    }

    public static function fromColors(array $colors): self
    {
        return new self($colors);
    }
}
