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
        return rtrim($reader->readString(12));
    }

    public function write(Writer $writer): void
    {
        $writer->write($this->id, 4);
        $writer->write($this->size, 4);
        $writer->write(0, 4);
        $writer->write($this->name, 12);
        $writer->writeRaw($this->content);
    }
}
