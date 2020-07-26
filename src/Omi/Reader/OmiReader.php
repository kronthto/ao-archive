<?php

namespace Kronthto\AOArchive\Omi\Reader;

use PhpBinaryReader\BinaryReader;

class OmiReader
{
    public function parse(string $data): OmiReadResult
    {
        $reader = new BinaryReader($data);

        $res = new OmiReadResult();

        $prevNType = null;

        while (true) {
            if ($reader->isEof()) {
                break;
            }

            $nType = $reader->readUInt32();
            $nDataCount = $reader->readUInt32();

            switch ($nType) {
                case DbTypes::DB_MONSTER_INFO:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        $res->monsters[] = $reader->readBytes(TypeSizes::MONSTER);
                    }
                    break;
                case DbTypes::DB_MAPOBJECT:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        $res->mapobject[] = $reader->readBytes(TypeSizes::MAPOBJECT);
                    }
                    break;
                case DbTypes::DB_RARE_ITEM:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        $res->rareitems[] = $reader->readBytes(TypeSizes::RAREITEM);
                    }
                    break;
                case DbTypes::DB_BUILDINGNPC:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        $res->buildingnpc[] = $reader->readBytes(TypeSizes::BUILDINGNPC);
                    }
                    break;
                case DbTypes::DB_MAP_INFO:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        $res->mapinfo[] = $reader->readBytes(TypeSizes::MAPINFO);
                    }
                    break;
                case DbTypes::DB_LUCKYMACHINE:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        $res->luckymachine[] = $reader->readBytes(TypeSizes::LUCKYMACHINE);
                    }
                    break;
                case DbTypes::DB_MYSTERY_ITEM_DROP:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        $res->mysteryitemdrop[] = $reader->readBytes(TypeSizes::MYSTERY_ITEM_DROP);
                    }
                    break;
                case DbTypes::DB_INVOKINGWEARITEM_DPNUM:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        $res->INVOKINGWEARITEM_DPNUM[] = $reader->readBytes(TypeSizes::INVOKINGWEARITEM_DPNUM);
                    }
                    break;
                case DbTypes::DB_INVOKINGWEARITEM_DPNUM_BY_USE:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        $res->INVOKINGWEARITEM_DPNUM_BY_USE[] = $reader->readBytes(TypeSizes::INVOKINGWEARITEM_DPNUM_BY_USE);
                    }
                    break;
                case DbTypes::DB_BURNING_MAP:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        $res->BURNING_MAP[] = $reader->readBytes(TypeSizes::BURNING_MAP);
                    }
                    break;
                case DbTypes::DB_MONSTER_MULTI_TARGET:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        $res->MONSTER_MULTI_TARGET[] = $reader->readBytes(TypeSizes::MONSTER_MULTI_TARGET);
                    }
                    break;
                case DbTypes::DB_ITEM:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        $res->item[] = $reader->readBytes(TypeSizes::ITEM);
                    }
                    break;
                case DbTypes::DB_MIXING_INFO:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        $res->MIXING_INFO[] = $reader->readBytes(TypeSizes::MIXING_INFO);
                    }
                    break;
                case DbTypes::DB_DISSOLUTIONITEM:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        $res->DISSOLUTIONITEM[] = $reader->readBytes(TypeSizes::DISSOLUTIONITEM);
                    }
                    break;
                case DbTypes::DB_PET_OPERATOR:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        $res->PET_OPERATOR[] = $reader->readBytes(TypeSizes::PET_OPERATOR);
                    }
                    break;
                case DbTypes::DB_PET_BASEDATA:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        $res->PET_BASEDATA[] = $reader->readBytes(TypeSizes::PET_BASEDATA);
                    }
                    break;
                case DbTypes::DB_PET_LEVELDATA:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        $res->PET_LEVELDATA[] = $reader->readBytes(TypeSizes::PET_LEVELDATA);
                    }
                    break;
                case DbTypes::CR_UK_18:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        // What is this? Do sth with it?
                        $res->CR_UK_18[] = $reader->readBytes(TypeSizes::CR_UK_18);
                    }
                    break;
                case DbTypes::CR_UK_19:
                    for ($i = 0; $i < $nDataCount; ++$i) {
                        // What is this? Do sth with it?
                        $res->CR_UK_19[] = $reader->readBytes(TypeSizes::CR_UK_19);
                    }
                    break;
                case DbTypes::CR_UK_20:
                    $reader->setPosition($reader->getPosition() + ($nDataCount * TypeSizes::CR_UK_20)); // Just skip
                    break;
                case DbTypes::CR_UK_21:
                    $reader->setPosition($reader->getPosition() + ($nDataCount * TypeSizes::CR_UK_21)); // Just skip
                    break;
                default:
                    throw new \RuntimeException('Undefined nType: ' . $nType . ' - previous: ' . $prevNType);
            }

            $prevNType = $nType;
        }

        return $res;
    }
}
