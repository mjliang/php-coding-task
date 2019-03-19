<?php
/**
 * Created by PhpStorm.
 * User: MJ
 * Date: 2019-03-19
 * Time: 19:00
 */
include __DIR__ . "/vendor/autoload.php";

use MjLiang\PhpCodingTask\orm\DownloadLog;

$downloadLog = DownloadLog::create();
echo ($downloadLog->isModified() ? 'DownloadLog is modified' : 'DownloadLog is not modified'), PHP_EOL;
$downloadLog->setFileId(1000)->setUserId(2000);
echo ($downloadLog->isModified() ? 'DownloadLog is modified' : 'DownloadLog is not modified'), PHP_EOL;
echo ("UserId is: " . $downloadLog->getUserId()), PHP_EOL;