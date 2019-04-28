<?php

namespace Kronthto\AOArchive\Omi\Parser;

class SmallItem extends Item
{
    protected const CPUDESKEYS = [
        1 => 'atk',
        2 => 'def',
        3 => 'fuel',
        4 => 'spirit',
        5 => 'shield',
        6 => 'eva',
    ];

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

    protected function getOnlyKeysByKind(): ?array
    {
        if ($this->data['kind'] === 26) {
            return [
                'id',
                'kind',
                'name',
                'ReqUnitKind',
                'ReqMinLevel',
                'ReqMaxLevel',
                'Weight',
                'ItemAttribute',
                'SourceIndex',
                'description',
                'DesParameters'
            ];
        }
        return null;
    }

    public function jsonSerialize()
    {
        $data = parent::jsonSerialize();

        $keys = $this->getOnlyKeysByKind();
        if ($keys === null) {
            $newData = &$data;
        } else {
            $newData = [];
            foreach ($keys as $key) {
                $newData[$key] = $data[$key];
            }
        }

        $this->specialTransformByKind($newData);

        return $newData;
    }

    protected function specialTransformByKind(&$arr): void
    {
        if ($this->data['kind'] === 26) {
            $arr['CPUStats'] = $this->mapCPUDesParams($arr['DesParameters']);
        }
    }

    protected function mapCPUDesParams(array $des): array
    {
        $new = [];
        foreach ($des as $desKey => $value) {
            if (!isset(static::CPUDESKEYS[$desKey])) {
                continue;
            }
            $new[static::CPUDESKEYS[$desKey]] = $value;
        }
        return $new;
    }
}
