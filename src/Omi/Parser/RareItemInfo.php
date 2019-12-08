<?php

namespace Kronthto\AOArchive\Omi\Parser;

// Fixes
class RareItemInfo extends AbstractParser
{
    // TODO: DesParams array like Item

    protected function getDefinition(): array
    {
        return [
            'id' => 'int',
            'name' => 'string32', // 30 + padding
            'ReqUseType' => 'int',
            'ReqMinLevel' => 'int',
            'ReqMaxLevel' => 'int',
            'ReqItemKind' => 'short', // BYTE with padding
            'ReqGearStat' => 'stat',
            'DesParameter1' => 'uint8',
            'DesParameter2' => 'uint8',
            'DesParameter3' => 'uint8',
            'DesParameter4' => 'uint8',
            'DesParameter5' => 'uint8',
            'DesParameter6' => 'uint8',
            'DesParameter7' => 'uint8',
            'DesParameter8' => 'uint8',
            'DesParameter9' => 'uint8',
            'PaddingDesParameter' => 1,
            'ParameterValue1' => 'float',
            'ParameterValue2' => 'float',
            'ParameterValue3' => 'float',
            'ParameterValue4' => 'float',
            'ParameterValue5' => 'float',
            'ParameterValue6' => 'float',
            'ParameterValue7' => 'float',
            'ParameterValue8' => 'float',
            'ParameterValue9' => 'float',
            'probability' => 'int',
        ];
    }
}
