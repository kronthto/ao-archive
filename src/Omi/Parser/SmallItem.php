<?php

namespace Kronthto\AOArchive\Omi\Parser;

class SmallItem extends Item
{
    public function __construct(string $data)
    {
        parent::__construct($data);

        $reducedData = [];
        foreach ([
                     'id',
                     'kind',
                     'name',
                     'AbilityMin',
                     'AbilityMax',
                     'ReqUnitKind',
                     'ReqMinLevel',
                     'ReqMaxLevel',
                     'Weight',
                     'HitRate', // Prob
                     'FractionResistance', // Pierce
                     'Range',
                     'ReAttacktime',
                     'Time',
                     'RangeAngle',
                     'UpgradeNum',
                     'LinkItem',
                     'ReqSP',
                     'SummonMonster',
                     'SkillLevel',
                     'ItemAttribute',
                     'BoosterAngle',
                     'SourceIndex',
                     'description',
                 ] as $key) {
            $reducedData[$key] = $this->data[$key];
        }

        $desParams = [];
        for ($i = 1; $i <= 8; ++$i) {
            if ($this->data['DesParameter' . $i]) {
                $desParams[$this->data['DesParameter' . $i]] = $this->data['ParameterValue' . $i];
            }
        }
        $reducedData['DesParameters'] = $desParams;

        $this->data = $reducedData;
    }
}
