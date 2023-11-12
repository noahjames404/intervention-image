<?php

declare(strict_types=1);

namespace Intervention\Image\Tests\Drivers\Imagick\Encoders;

use Imagick;
use ImagickPixel;
use Intervention\Image\Drivers\Imagick\Encoders\WebpEncoder;
use Intervention\Image\Drivers\Imagick\Image;
use Intervention\Image\Tests\TestCase;

/**
 * @requires extension imagick
 */
final class WebpEncoderTest extends TestCase
{
    protected function getTestImage(): Image
    {
        $imagick = new Imagick();
        $imagick->newImage(3, 2, new ImagickPixel('red'), 'png');

        return new Image($imagick);
    }

    public function testEncode(): void
    {
        $image = $this->getTestImage();
        $encoder = new WebpEncoder(75);
        $result = $encoder->encode($image);
        $this->assertMimeType('image/webp', (string) $result);
    }
}
