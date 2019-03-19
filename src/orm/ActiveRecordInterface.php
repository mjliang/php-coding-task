<?php

namespace MjLiang\PhpCodingTask\orm;

interface ActiveRecordInterface
{
    /**
     * Indicates that the underlying row of data within the model has been
     * modified
     *
     * @return boolean
     */
    public function isModified(): bool;
}
