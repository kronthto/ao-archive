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
            'DesParameter1' => 'byte',
            'DesParameter2' => 'byte',
            'DesParameter3' => 'byte',
            'DesParameter4' => 'byte',
            'DesParameter5' => 'byte',
            'DesParameter6' => 'byte',
            'DesParameter7' => 'byte',
            'DesParameter8' => 'byte',
            'DesParameter9' => 'byte',
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
