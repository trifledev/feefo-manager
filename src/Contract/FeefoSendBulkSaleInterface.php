<?php

namespace Trifledev\Feefo\Contract;

/**
 * Interface FeefoSendBulkSaleInterface
 * @package Trifledev\Feefo\Contract
 */
interface FeefoSendBulkSaleInterface
{
    /**
     * @param string $path
     * @return mixed
     */
    public function setExportStoragePath($path);
}