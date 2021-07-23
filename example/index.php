<?php

/*
 * (c) ZHB <vincent.huck.pro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Zhb\WeatherGradient\Gradient;

require_once __DIR__.'/../vendor/autoload.php';

?>

<html>
<head>
    <title>Color gradient</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.6/tailwind.min.css" integrity="sha512-EYVjvPqURgm6pqtZxeqvlbZtnWjYmecnLS0QEedL51IUdaH0HXmSHjTKK7X1yWmiB3/5U1fwIv06ZDwLoo1LdA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="my-5 mx-5">
        <div class="flex flex-row text-xs space-y-0 space-x-4">
            <div class="w-40 flex-shrink-0">
                <div class="h-10 flex flex-col justify-center">
                    <div class="text-sm font-semibold text-gray-900">Temperature</div>
                    <div>
                        <code class="text-xs text-gray-500">-20 °C to 40 °C</code>
                    </div>
                </div>
            </div>
            <div class="min-w-0 flex-1 grid grid-cols-10 gap-x-1 gap-y-3">
                <?php
                $colors = [
                    -20 => [124, 58, 237], // purple
                    -10 => [59, 130, 246], // blue
                    0 => [239, 246, 255], // white
                    20 => [252, 211, 77], // yellow
                    35 => [239, 68, 68], // red
                    10 => [16, 185, 129], // green
                    40 => [236, 72, 153], // pink
                ];

                $gradient = Gradient::fromColors($colors);

                for ($temperature = -20; $temperature <= 40; ++$temperature) {
                    $color = $gradient->colorAtGradientPosition($temperature); ?>
                    <div class="space-y-1.5">
                        <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0" style="background-color:<?php echo $color; ?>;"></div>
                        <div class="px-0.5 md:flex md:justify-between md:space-x-2 2xl:space-x-0 2xl:block">
                            <div class="w-20 font-medium text-gray-900"><?php echo $temperature; ?> °C</div><div><?php echo $color; ?></div>
                        </div>
                    </div>
                <?php
                } ?>
            </div>
        </div>
    </div>
    </body>
</html>