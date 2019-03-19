<?php
/**
 * Created by PhpStorm.
 * User: MJ
 * Date: 2019-03-19
 * Time: 21:28
 */

namespace MjLiang\PhpCodingTask\Tests\orm;

use MjLiang\PhpCodingTask\orm\DownloadLog;
use PHPUnit\Framework\TestCase;

class DownloadLogTest extends TestCase
{

    /**
     * @test
     */
    public function cannotAssignStringToFileId()
    {
        $this->expectException(\Exception::class);

        $downloadLog = DownloadLog::create();

        $downloadLog->setFileId('abc');
    }


    /**
     * @test
     */
    public function cannotAssignStringToUserId()
    {
        $this->expectException(\Exception::class);

        $downloadLog = DownloadLog::create();

        $downloadLog->setUserId('abc');
    }

    /**
     * @test
     */
    public function assignIntToUserId()
    {
        $downloadLog = DownloadLog::create();

        $downloadLog->setUserId(12345);

        $this->assertEquals(12345, $downloadLog->getUserId());
    }

    /**
     * @test
     */
    public function assignIntToFileId()
    {
        $downloadLog = DownloadLog::create();

        $downloadLog->setFileId(12345);

        $this->assertEquals(12345, $downloadLog->getFileId());
    }

    /**
     * @test
     */
    public function isNotModified()
    {
        $downloadLog = DownloadLog::create();

        $this->assertFalse($downloadLog->isModified());
    }

    /**
     * @test
     */
    public function isModified()
    {
        $downloadLog = DownloadLog::create();
        $downloadLog->setFileId(1000)->setUserId(2000);
        $this->assertTrue($downloadLog->isModified());
    }
}
