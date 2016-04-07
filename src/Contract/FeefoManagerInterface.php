<?php

namespace Trifledev\Feefo\Contract;


/**
 * Interface FeefoManagerInterface
 * @package Trifledev\Feefo\Contract
 */
interface FeefoManagerInterface
{
    /**
     * @param $domain
     * @return mixed
     */
    public function setDomain($domain);
}