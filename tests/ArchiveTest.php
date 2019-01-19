<?php

namespace Tests;

use Kronthto\AOArchive\Archive\Archive;
use PHPUnit\Framework\TestCase;

class ArchiveTest extends TestCase
{
    public function testArchiveUnpackingPacking()
    {
        $chaffObjOrg = file_get_contents(__DIR__ . '/data/06508080_AwesomeFaceChaffs.obj');

        $orgCheckSum = sha1($chaffObjOrg);

        $unpacked = new Archive($chaffObjOrg, true);

        $this->assertEquals('06508080', $unpacked->entries[0]->name);
        $this->assertSame(654, $unpacked->entries[0]->size);
        $this->assertStringStartsWith('xof', $unpacked->entries[0]->content);
        $this->assertEquals('06508081', $unpacked->entries[1]->name);

        $repacked = $unpacked->pack();

        $this->assertSame($orgCheckSum, sha1($repacked));
        $this->assertSame($chaffObjOrg, $repacked);
    }
}
