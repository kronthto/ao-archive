<?php

namespace Tests;

use Kronthto\AOArchive\Writer;
use PHPUnit\Framework\TestCase;

class BinaryWriterTest extends TestCase
{
    protected function getTestStream()
    {
        return fopen('php://memory', 'rb+');
    }

    protected function getTestStreamData($buffer): string
    {
        rewind($buffer);
        $data = stream_get_contents($buffer);
        fclose($buffer);

        return $data;
    }

    public function testWritingStrings()
    {
        $buffer = $this->getTestStream();

        $writer = new Writer($buffer);

        $writer->write('test', 6);

        $data = $this->getTestStreamData($buffer);

        $this->assertSame(6, \strlen($data));
        $this->assertStringStartsWith('test', $data);
        $this->assertStringEndsWith(\chr(0), $data);
    }

    public function testWritingInts()
    {
        $buffer = $this->getTestStream();

        $writer = new Writer($buffer);

        $writer->write(66, 4);

        $data = $this->getTestStreamData($buffer);

        $this->assertSame(4, \strlen($data));
        $this->assertSame(66, unpack('V', $data)[1]);
        $this->assertStringEndsWith(\chr(0) . \chr(0) . \chr(0), $data);
    }

    public function testWritingBiggerInts()
    {
        $buffer = $this->getTestStream();

        $writer = new Writer($buffer);

        $writer->write(300, 4);

        $data = $this->getTestStreamData($buffer);

        $this->assertSame(4, \strlen($data));
        $this->assertSame(300, unpack('V', $data)[1]);
        $this->assertStringEndsWith(\chr(0) . \chr(0), $data);
        $this->assertSame(1, \ord($data[1])); // 1x 256
        $this->assertSame(44, \ord($data[0]));
    }
}
