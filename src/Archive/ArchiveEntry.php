<?php

namespace Kronthto\AOArchive\Archive;

use Kronthto\AOArchive\Writer;
use PhpBinaryReader\BinaryReader;

class ArchiveEntry
{
    /** @var int */
    public $id;
    /** @var string */
    public $name;
    /** @var string */
    public $content;
    /** @var int */
    public $size;

    public function __construct(BinaryReader $reader, bool $inArchive)
    {
        if ($inArchive) {
            $this->id = $reader->readUInt32();
            $this->size = $reader->readUInt32();
            $reader->readUInt32(); // skip
            $this->name = $this->readName($reader);
            $this->content = $reader->readBytes($this->size);
        } else {
            throw new \BadMethodCallException('Not implemented');
        }
    }

    protected function readName(BinaryReader $reader): string
    {
        $name = '';
        $num = 0;

        do {
            $peekedChar = self::peekBytes($reader, 1);
            if (\ord($peekedChar) === 0) {
                break;
            }
            $name[$num] = $reader->readBytes(1);
            ++$num;
        } while ($num < 12);

        $reader->readBytes(12 - $num);

        return $name;
    }

    private static function peekBytes(BinaryReader $reader, int $count): string
    {
        $currentPos = $reader->getPosition();

        $bytes = $reader->readBytes($count);

        $reader->setPosition($currentPos);

        return $bytes;
    }

    public function write(Writer $writer): void
    {
        $writer->write($this->id, 4);
        $writer->write($this->size, 4);
        $writer->write(0, 4);
        $writer->writeRaw($this->name);
        $writer->write(0, 12 - \strlen($this->name));
        $writer->writeRaw($this->content);
    }
}
