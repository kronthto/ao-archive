<?php

namespace Kronthto\AOArchive;

use PhpBinaryReader\BinaryReader;

class Archive
{
    protected const HEADER = [232, 3, 0, 0, 232, 3, 0, 0];

    /** @var array|ArchiveEntry[] */
    public $entries = [];

    public function __construct($data, bool $isPacked)
    {
        if ($isPacked) {
            if (!\is_string($data)) {
                throw new \InvalidArgumentException('Expected string of data for packed archive');
            }

            $reader = new BinaryReader($data);
            $reader->setPosition(12); // Skip first 4 and also 8 header bytes

            $numItems = $reader->readUInt32();
            $reader->readUInt32(); // skip

            for ($i = 0; $i < $numItems; $i++) {
                $this->entries[] = new ArchiveEntry($reader, true);
            }
        } else {
            if (!\is_array($data)) {
                throw new \InvalidArgumentException('Expected array of entries for unpacked archive');
            }
        }
    }

    public function pack(): string
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'CrHex');
        $stream = fopen($tmpFile, 'wb');

        $writer = new Writer($stream);

        foreach (static::HEADER as $headerChr) {
            $writer->writeRaw(\chr($headerChr));
        }
        $writer->write($this->sumSizes(), 4);
        $writer->write(\count($this->entries), 4);
        $writer->write(0, 4);
        foreach ($this->entries as $entry) {
            $entry->write($writer);
        }

        fclose($stream);

        $data = file_get_contents($tmpFile);
        unlink($tmpFile);
        return $data;
    }

    protected function sumSizes(): int
    {
        $sum = 0;
        foreach ($this->entries as $entry) {
            $sum += $entry->size;
        }
        return $sum;
    }

    public function unpack(string $path): void
    {
        foreach ($this->entries as $entry) {
            file_put_contents($path . $entry->name . '-' . $entry->id, $entry->content);
        }
    }
}
