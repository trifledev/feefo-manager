<?php

namespace Trifledev\Feefo\Api;

use Trifledev\Feefo\FeefoManager;

/**
 * Class FeefoSendSale
 * @package Trifledev\Feefo\Api
 */
class FeefoSendSingleSale extends FeefoManager
{

    /**
     * @param $order
     * @return bool
     */
    function sendSingleOrder($order) {

        if($this->getValidator()->isOrderValid($order)) {

            $endpoint = $this->getApiUrl().'/feefo/entersaleremotely.jsp';

            $data = http_build_query($order, '', '&');
            $ch=curl_init();
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $reply=curl_exec($ch);
            curl_close($ch);
            echo "The response received was: $reply";

        } else {
            return false;
        }

    }
}