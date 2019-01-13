<?php

namespace Kronthto\AOArchive\Omi\Parser;

use PhpBinaryReader\BinaryReader;

abstract class AbstractParser
{
    protected $data = [];

    public function __construct(string $data)
    {
        $reader = new BinaryReader($data);

        foreach ($this->getDefinition() as $name => $type) {
            $this->data[$name] = $this->readValue($reader, $type);
        }

        $this->data = array_filter($this->data, function ($var) {
            return $var !== null;
        });
    }

    protected function readValue(BinaryReader $reader, $type)
    {
        if (\is_int($type)) {
            $reader->readBytes($type); // discard
            return null;
        }

        if (preg_match('/^string(\d+)$/', $type, $matches) === 1) {
            return trim($reader->readString((int) $matches[1]));
        }

        switch ($type) {
            case 'int':
                return $reader->readInt32();
            case 'uint':
                return $reader->readUInt32();
            case 'byte':
                return $reader->readInt8();
            case 'stat':
                $stat = [];
                for ($i = 0; $i < 6; ++$i) {
                    $stat[] = $reader->readInt16();
                }

                return $stat;
            case 'short':
                return $reader->readInt16();
            case 'float':
                return unpack('f', $reader->readBytes(4))[1];
            case 'long':
                return $reader->readInt64();
            default:
                throw new \BadMethodCallException('Not implemented type: ' . $type);
        }
    }

    /**
     * Define the assoc array [name => type] for the data.
     *
     * @return array
     */
    abstract protected function getDefinition(): array;

    public function getData(): array
    {
        return $this->data;
    }
}
