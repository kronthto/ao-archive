<?php

namespace Kronthto\AOArchive\SMA;

use PhpBinaryReader\BinaryReader;

class Reader
{
    public function determineMapSize(int $dataLength): int
    {
        if ($dataLength > 1000000 && $dataLength < 1500000) {
            return 128;
        }
        if ($dataLength > 4880760 && $dataLength < 5200000) {
            return 256;
        }
        throw new \Exception('Unknown mapsize');
    }

    public function parse(string $data): array
    {
        $reader = new BinaryReader($data);

        $mapSize = $this->determineMapSize(strlen($data));
        $sizeOfTileinfo = 76;

        $reader->setPosition(20+($mapSize*$mapSize*$sizeOfTileinfo));

        $numMonsters = $reader->readInt32();

        if ($numMonsters <= 0) {
            throw new \Exception('No monsters: '. $numMonsters);
        }

        $monsters = [];

        for ($i = 0; $i < $numMonsters; $i++) {
            $mi = new MonsterInfo($reader->readBytes(60));
            $monsters[] = $mi;
        }

        return $monsters;
    }
}
