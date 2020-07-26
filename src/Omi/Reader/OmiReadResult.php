<?php

namespace Kronthto\AOArchive\Omi\Reader;

use Kronthto\AOArchive\Omi\Parser\AbstractParser;
use Kronthto\AOArchive\Omi\Parser\MapInfo;
use Kronthto\AOArchive\Omi\Parser\Monster;
use Kronthto\AOArchive\Omi\Parser\MysteryItemDrop;
use Kronthto\AOArchive\Omi\Parser\RareItemInfo;
use Kronthto\AOArchive\Omi\Parser\SmallItem;

class OmiReadResult
{
    public $monsters = [];
    public $mapobject = [];
    public $rareitems = []; // Fixes
    public $buildingnpc = [];
    public $mapinfo = [];
    public $luckymachine = [];
    public $mysteryitemdrop = [];
    public $INVOKINGWEARITEM_DPNUM = [];
    public $INVOKINGWEARITEM_DPNUM_BY_USE = [];
    public $BURNING_MAP = [];
    public $MONSTER_MULTI_TARGET = [];
    public $PET_OPERATOR = [];
    public $PET_LEVELDATA = [];
    public $PET_BASEDATA = [];
    public $item = [];
    public $MIXING_INFO = [];
    public $DISSOLUTIONITEM = [];
    public $CR_UK_18 = [];
    public $CR_UK_19 = [];
    // public $CR_UK_20 = [];
    // public $CR_UK_21 = [];

    protected const PARSERMAPPING = [
        'monsters' => Monster::class,
        'mapobject' => null,
        'rareitems' => RareItemInfo::class, // Fixes
        'buildingnpc' => null,
        'mapinfo' => MapInfo::class,
        'luckymachine' => null,
        'mysteryitemdrop' => MysteryItemDrop::class,
        'INVOKINGWEARITEM_DPNUM' => null,
        'INVOKINGWEARITEM_DPNUM_BY_USE' => null,
        'BURNING_MAP' => null,
        'MONSTER_MULTI_TARGET' => null,
        'PET_OPERATOR' => null,
        'PET_LEVELDATA' => null,
        'PET_BASEDATA' => null,
        'item' => SmallItem::class,
        'MIXING_INFO' => null,
        'DISSOLUTIONITEM' => null,
    ];

    protected static function getParserMapping(string $ns): ?string
    {
        return static::PARSERMAPPING[$ns] ?? null;
    }

    /**
     * @param callable $transformer Gets each entry as arg1. Is also passed the namespace as arg2 (cannot be modified). Must return the new value
     *
     * @return static
     */
    public function map(callable $transformer): self
    {
        $new = new static();

        foreach ($this as $ns => &$entries) {
            foreach ($entries as $key => $entry) {
                $newEntry = $transformer($entry, $ns);

                if ($newEntry instanceof AbstractParser && isset($newEntry->getData()['id'])) {
                    $key = $newEntry->getData()['id'];
                }

                $new->{$ns}[$key] = $newEntry;
            }
        }

        return $new;
    }

    public function parseToEntities(): self
    {
        return $this->map(function ($value, string $ns): ?AbstractParser {
            $parser = static::getParserMapping($ns);
            if (!$parser) {
                return null;
            }

            return new $parser($value);
        });
    }
}
