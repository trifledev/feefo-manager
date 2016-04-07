<?php

namespace Trifledev\Feefo;

/**
 * Class FeefoConfig
 * @package Trifledev\Feefo
 */
class FeefoConfig
{

    /**
     * @var array
     */
    private $inform_methods = ['ftp','http','enc','host',];
    /**
     * @var array
     */
    private $settings = [
        'inform_encryption' => false,
        'inform_method' => 'ftp'
    ];

    /**
     * @param $setting
     * @param $value
     */
    function setSetting($setting, $value) {
        $this->settings[$setting] = $value;
    }

    /**
     * @param $setting
     * @return mixed
     */
    function getSetting($setting) {
        return $this->settings[$setting];
    }

    /**
     * @return array
     */
    function getSettings() {
        return $this->settings;
    }

    /**
     * @return array
     */
    public function getInformMethods()
    {
        return $this->inform_methods;
    }

    /**
     * @param array $inform_methods
     */
    public function setInformMethods($inform_methods)
    {
        $this->inform_methods = $inform_methods;
    }


}