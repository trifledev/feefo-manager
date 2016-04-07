<?php

namespace Trifledev\Feefo\Api;

use Trifledev\Feefo\FeefoManager;

/**
 * Class FeefoLinks
 * @package Trifledev\Feefo\Api
 */
class FeefoLinks extends FeefoManager
{
    /**
     * @return string
     */
    function getReviewLinkScript() {
        return '<script type="text/javascript" src="'.$this->getApiUrl().'/reviewjs/'.$this->getLogon().'"></script>';
    }

    /**
     * @param $reference
     * @param int $popupWidth
     * @param int $popupHeight
     * @param string $logoTemplate
     * @param string $imgTitle
     * @return string
     */
    function getProductLink($reference, $popupWidth=600, $popupHeight=400, $logoTemplate='service-stars-grey-175x44_en.png', $imgTitle='See what our customers sayabout us') {
        $link = '<a target="_blank"
            href="'.$this->getApiUrl().'/feefo/viewvendor.jsp?logon='.$this->getLogon().'&vendorref='.$reference.'
            onclick="window.open(this.href,\'Feefo\',\'width='.$popupWidth.',height='.$popupHeight.',scrollbars,resi
            zable\');return false;">
            <img alt="Feefo logo"
            border="0" src="'.$this->getApiUrl().'/feefo/feefologo.jsp?logon='.$this->getLogon().'&template='.$logoTemplate.'" title="'.$imgTitle.'">
        </a>';
        return $link;
    }

    /**
     * @return string
     */
    function getDisplayContainer() {
        return '<div id="feefologohere"></div>';
    }
}