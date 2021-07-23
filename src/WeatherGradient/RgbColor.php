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

class RgbColor
{
    private int $r;
    private int $g;
    private int $b;

    private function __construct(int $r, int $g, int $b)
    {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
    }

    public function getRGB(): array
    {
        return [$this->r, $this->g, $this->b];
    }

    public function getR(): int
    {
        return $this->r;
    }

    public function getG(): int
    {
        return $this->g;
    }

    public function getB(): int
    {
        return $this->b;
    }

    /**
     * Create a RgbColor from an array of RGB colors.
     */
    public static function fromRgb(array $rgb): self
    {
        return new self(...$rgb);
    }

    public function __toString(): string
    {
        return sprintf('rgb(%d, %d, %d)', $this->r, $this->g, $this->b);
    }
}
