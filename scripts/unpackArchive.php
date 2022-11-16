<?php

require_once __DIR__ . '/_init.php';

use Kronthto\AOArchive\Archive\Archive;

ini_set('memory_limit', '500M');

// Can be used for both, obj & eff Archives

#$xorer = new \Kronthto\AOArchive\HExXorerCopy('XX');
$arch = new Archive(file_get_contents($argv[1]), true);

#$arch = $arch->map(function (\Kronthto\AOArchive\Archive\ArchiveEntry $entry) use ($xorer): \Kronthto\AOArchive\Archive\ArchiveEntry {
#    $entry->content = $xorer->doXor($entry->content);
#
#    return $entry;
#});


$outdir = sprintf('dec_%s', basename($argv[1]));

mkdir($outdir);

$arch->unpack("$outdir".DIRECTORY_SEPARATOR);
