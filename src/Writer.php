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

    public function write($value, int $length): void
    {
        // Padding
        if ($value === 0 || $value === null) {
            for ($i = 0; $i < $length; ++$i) {
                fwrite($this->stream, \chr(0));
            }

            return;
        }

        // String with padding
        if (\is_string($value)) {
            fwrite($this->stream, $value, $length);
            $this->write(0, $length - \strlen($value)); // Pad
            return;
        }

        // Int with padding & endianess
        if (\is_int($value)) {
            // todo: this is Painful.. - maybe cleaner with pack / X? ......
            // i feel like it should be possible without converting to bin stringm padding string null, and bindec again
            $binaryPadded = str_pad(decbin($value), 8 * $length, '0', STR_PAD_LEFT);
            for ($i = 0; $i < $length; ++$i) {
                $byte = substr($binaryPadded, (($length - 1) - $i) * 8, 8);
                fwrite($this->stream, \chr(bindec($byte)));
            }

            return;
        }

        throw new \BadMethodCallException('Not implemented type to convert to binary: ' . \gettype($value));
    }

    public function writeRaw(string $bytes): void
    {
        fwrite($this->stream, $bytes);
    }
}
