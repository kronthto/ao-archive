<?php

namespace Kronthto\AOArchive\Omi\Parser;

class MysteryItemDrop extends AbstractParser
{
    protected function getDefinition(): array
    {
        return [
            'MysteryItemDropNum' => 'int',
            'ReqUnitKind' => 'short',
            'ReqMinLevel' => 'byte',
            'ReqMaxLevel' => 'byte',
            'DropItemNum' => 'int',
            'MinCount' => 'int',
            'MaxCount' => 'int',
            'Probability' => 'int',
            'PrefixProbability' => 'int',
            'SuffixProbability' => 'int',
            'Period' => 'short',
            'CountPerPeriod' => 'int',
            'DropCount' => 'int',
        ];
    }
}
