<?php


namespace MjLiang\PhpCodingTask\orm;

/**
 * Class DownloadLog
 *
 * @method DownloadLog setFileId(int $value)
 * @method DownloadLog setUserId(int $value)
 * @method int getUserId()
 * @method int getFileId()
 * @method static DownloadLog create()
 *
 * @package MjLiang\PhpCodingTask\orm
 */
final class DownloadLog extends ActiveRecord
{
    use NumericValidator;
    /**
     * @var int
     */
    private $fileId;

    /**
     * @var int
     */
    private $userId;


}
