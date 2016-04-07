<?php

namespace Trifledev\Feefo\Util;

/**
 * Class FeefoHelper
 * @package Trifledev\Feefo\Util
 */
class FeefoHelper
{
    /**
     * @param $array
     * @return array
     */
    static function getArrayKeys($array) {
        return array_keys($array);
    }

    /**
     * @param $array
     * @return mixed
     */
    static function getFormLabels($array) {
        foreach($array as $key=>$val) {
            $keys = explode('_',$key);
            $keys = array_map('ucfirst',$keys);
            $keys = implode(' ',$keys);
            $array[$key] = $keys;
        }
        return $array;
    }

    /**
     * @param $rating
     * @return array
     */
    static function getRatingStyle($rating) {
        switch($rating) {
            case '++':
                $icon = 'fa fa-plus-circle';
                $color='dark-green';
                break;
            case '+':
                $icon = 'fa fa-plus-circle';
                $color='light-green';
                break;
            case '--':
                $icon = 'fa fa-minus-circle';
                $color='yellow';
                break;
            case '-':
                $icon = 'fa fa-minus-circle';
                $color = 'orange';
                break;
            default:
                $icon = 'fa fa-minus';
                $color='grey';
                break;
        }
        return ['icon'=>$icon,'color'=>$color];
    }

    /**
     * @param $time
     * @return string
     */
    static function getTimeElapsed($time)
    {

        $time = time() - strtotime($time); // to get the time since that moment
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'').' ago';
        }

    }

    /**
     * @param string $date
     * @return bool|string
     */
    static function getHumanDate($date='') {
        return date('d. M Y',strtotime($date));
    }

    /**
     * @param $array
     * @return array
     */
    static function convertArrayKeysToUtf8($array){
        $convertedArray = array();
        foreach($array as $key => $value) {
            if(!mb_check_encoding($key, 'UTF-8')) $key = utf8_encode($key);
            if(is_array($value)) $value = self::convertArrayKeysToUtf8($value);

            $convertedArray[$key] = $value;
        }
        return $convertedArray;
    }
}