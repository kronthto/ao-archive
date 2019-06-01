<?php

require_once __DIR__ . '/../vendor/autoload.php';

$omiReader = new \Kronthto\AOArchive\Omi\Reader\OmiReader();

$readOmi = $omiReader->parse(file_get_contents('C:\Program Files (x86)\MasangSoft\ACEonline_DE\Res-Tex\omi.tex'));

$readOmi = $readOmi->parseToEntities();

foreach ($readOmi->item as $item) {
    if (strpos($item->getData()['name'], 'Invisible') !== false) {
        var_dump($item);
    }
}
