<?php

require_once __DIR__ . '/_init.php';

use Kronthto\AOArchive\Archive\Archive;

// Can also be used to build .eff files

$xFile = new \Kronthto\AOArchive\Archive\ArchiveEntryFromData();
$xFile->id = 0;
$xFile->name = '06428040';
$xFile->content = file_get_contents('06402100-0.x');
$xFile->size = strlen($xFile->content);

$tgaFile = new \Kronthto\AOArchive\Archive\ArchiveEntryFromData();
$tgaFile->id = 0;
$tgaFile->name = '06428041';
$tgaFile->content = file_get_contents('06402101-0_blue.tga');
$tgaFile->size = strlen($tgaFile->content);


$arch = new Archive([$xFile, $tgaFile], false);

file_put_contents('06428040_blue.obj', $arch->pack());
