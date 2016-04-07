<?php
/**
 * Copyright 01.04.2016 Victoria Speckmann-Bresges
 */

namespace Trifledev\Feefo;

use Trifledev\Feefo\Contract\FeefoManagerInterface;
use Trifledev\Feefo\Util\FeefoFtp;
use Trifledev\Feefo\Util\FeefoHelper;
use Trifledev\Feefo\Util\FeefoParser;
use Trifledev\Feefo\Util\FeefoValidator;

/**
 * Class FeefoManager
 * @package Trifledev\Feefo
 */
class FeefoManager implements FeefoManagerInterface
{

    /**
     * @var
     */
    private $config;
    /**
     * @var
     */
    private $parser;
    /**
     * @var
     */
    private $helper;
    /**
     * @var
     */
    private $validator;
    /**
     * @var
     */
    private $ftp;

    /**
     * @var
     */
    private $domain;
    /**
     * @var string
     */
    private $endpoint = 'http://www.feefo.com';
    /**
     * @var string
     */
    private $logon = 'www.examplesupplier.com';

    /**
     * @var string
     */
    private $ftp_server = 'ftp.feefo.com';

    /**
     * @var string
     */
    private $ftp_user = 'www-examplesupplier-com@feefo.com';

    /**
     * @var string
     */
    private $ftp_password = 'www.examplesupplier.com';

    /**
     * FeefoManager constructor.
     * @param $domain
     */
    function __construct($domain) {

        $this->setDomain($domain);
        //$this->setCredentials($domain);
        $this->setConfig(new FeefoConfig());
        $this->setParser(new FeefoParser());
        $this->setHelper(new FeefoHelper());
        $this->setValidator(new FeefoValidator());
        $this->setFtp(new FeefoFtp($this->getFtpServer(),$this->getFtpUser(),$this->getFtpPassword()));

    }
    /**
     * @return FeefoConfig
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @param $parser
     */
    function setParser($parser) {
        $this->parser = $parser;
    }

    /**
     * @return FeefoParser
     */
    function getParser() {
        return $this->parser;
    }

    /**
     * @param $helper
     */
    function setHelper($helper) {
        $this->helper = $helper;
    }

    /**
     * @return FeefoHelper
     */
    function getHelper() {
        return $this->helper;
    }

    /**
     * @param $domain
     */
    function setDomain($domain) {
        $this->domain = $domain;
    }

    /**
     * @return mixed
     */
    function getDomain() {
        return $this->domain;
    }

    /**
     * @param $endpoint
     */
    function setEndpoint($endpoint) {
        $this->endpoint = $endpoint;
    }

    /**
     * @return string
     */
    function getEndpoint() {
        return $this->endpoint;
    }

    /**
     * @return string
     */
    function getApiUrl() {
        return $this->getEndpoint();
    }

    /**
     * @return FeefoValidator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param mixed $validator
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return string
     */
    public function getFtpServer()
    {
        return $this->ftp_server;
    }

    /**
     * @param string $ftp_server
     */
    public function setFtpServer($ftp_server)
    {
        $this->ftp_server = $ftp_server;
    }

    /**
     * @return string
     */
    public function getFtpUser()
    {
        return $this->ftp_user;
    }

    /**
     * @param string $ftp_user
     */
    public function setFtpUser($ftp_user)
    {
        $this->ftp_user = $ftp_user;
    }

    /**
     * @return string
     */
    public function getFtpPassword()
    {
        return $this->ftp_password;
    }

    /**
     * @param string $ftp_password
     */
    public function setFtpPassword($ftp_password)
    {
        $this->ftp_password = $ftp_password;
    }

    /**
     * @return mixed
     * @return FeefoFtp
     */
    public function getFtp()
    {
        return $this->ftp;
    }

    /**
     * @param mixed $ftp
     */
    public function setFtp($ftp)
    {
        $this->ftp = $ftp;
    }

    /**
     * @return string
     */
    public function getLogon()
    {
        return $this->logon;
    }

    /**
     * @param string $logon
     */
    public function setLogon($logon)
    {
        $this->logon = $logon;
    }


}