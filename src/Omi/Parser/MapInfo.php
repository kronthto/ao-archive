<?php

namespace Kronthto\AOArchive\Omi\Parser;

class MapInfo extends AbstractParser
{
    protected function getDefinition(): array
    {
        return [
            'MapIndex' => 'short',
            'RenderMapIndex' => 'short',
            'BeforeMapIndex' => 'short',
            'MapName' => 'string40',
            'skip' => 94,
            'Dat' => 'short',
            'Map' => 'short',
            'Tex' => 'short',
            'Cloud' => 'short',
            'Sky' => 'short',
            'Nsky' => 'short',
            'Bgm' => 'short',
        ];
    }
}
