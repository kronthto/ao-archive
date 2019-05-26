<?php

require_once __DIR__ . '/_init.php';

use Kronthto\AOArchive\Archive\Archive;

// Can be used for both, obj & eff Archives

$arch = new Archive(file_get_contents($argv[1]), true);

$outdir = sprintf('dec_%s', $argv[1]);

mkdir($outdir);

$arch->unpack("$outdir\\");
