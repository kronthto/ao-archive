<?php

namespace Kronthto\AOArchive;

class Writer
{
    /** @var resource */
    protected $stream;

    public function __construct($stream)
    {
        if (!\is_resource($stream)) {
            throw new \InvalidArgumentException('Expected stream');
        }
        $this->stream = $stream;
    }

    protected function makeBinary($value): string
    {
        if (\is_int($value)) {
            return decbin($value);
        }
        if (\is_string($value)) {
            return base_convert(unpack('H*', $value)[1], 16, 2);
        }

        throw new \BadMethodCallException('Not implemented type to convert to binary: ' . \gettype($value));
    }

    public function write($value, int $length): void
    {
        $changeEndian = \is_int($value);
        // Painful..
        $binaryPadded = str_pad($this->makeBinary($value), 8 * $length, '0', STR_PAD_LEFT);
        for ($i = 0; $i < $length; ++$i) {
            $byte = substr($binaryPadded, ($changeEndian ? (($length - 1) - $i) : $i) * 8, 8);
            fwrite($this->stream, \chr(bindec($byte)));
        }
    }

    public function writeRaw(string $bytes): void
    {
        fwrite($this->stream, $bytes);
    }
}
