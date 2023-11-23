<?php

namespace Intervention\Image\Drivers\Imagick;

use Imagick;
use ImagickDraw;
use Intervention\Image\Drivers\AbstractFont;
use Intervention\Image\Exceptions\FontException;
use Intervention\Image\Geometry\Polygon;
use Intervention\Image\Geometry\Rectangle;
use Intervention\Image\Interfaces\ColorspaceInterface;

class Font extends AbstractFont
{
    public function toImagickDraw(?ColorspaceInterface $colorspace = null): ImagickDraw
    {
        if (!$this->hasFilename()) {
            throw new FontException('No font file specified.');
        }

        $draw = new ImagickDraw();
        $draw->setStrokeAntialias(true);
        $draw->setTextAntialias(true);
        $draw->setFont($this->filename());
        $draw->setFontSize($this->size());
        $draw->setTextAlignment(Imagick::ALIGN_LEFT);

        if ($colorspace) {
            $draw->setFillColor(
                $this->colorToPixel($this->color(), $colorspace)
            );
        }

        return $draw;
    }

    /**
     * Calculate box size of current font
     *
     * @return Polygon
     */
    public function getBoxSize(string $text): Polygon
    {
        // no text - no box size
        if (mb_strlen($text) === 0) {
            return (new Rectangle(0, 0));
        }

        $draw = $this->toImagickDraw();
        $draw->setStrokeAntialias(true);
        $draw->setTextAntialias(true);
        $dimensions = (new Imagick())->queryFontMetrics($draw, $text);

        return (new Rectangle(
            intval(round($dimensions['textWidth'])),
            intval(round($dimensions['ascender'] + $dimensions['descender'])),
        ));
    }
}
