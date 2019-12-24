<?php

namespace Kronthto\AOArchive\SMA;

use Kronthto\AOArchive\Omi\Parser\AbstractParser;

class MonsterInfo extends AbstractParser
{
    protected function getDefinition(): array
    {
        return [
            'strRegionName' => 'string40',
            'sMonType' => 'uint', // 30 + padding
            'sStartx' => 'short',
            'sStartz' => 'short',
            'sEndx' => 'short',
            'sEndz' => 'short',
            'sMaxMon' => 'short',
            'sResNum' => 'short',
            'sResTime' => 'ushort',
            'bMonType' => 'byte',
        ];
    }
}
