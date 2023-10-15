<?php

namespace Intervention\Image\Colors\Rgba\Channels;

class Alpha extends Red
{
    public function toString(): string
    {
        return strval(round($this->normalize(), 6));
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
