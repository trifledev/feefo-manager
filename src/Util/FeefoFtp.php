<?php

namespace Trifledev\Feefo\Util;

/**
 * Class FeefoFtp
 * @package Trifledev\Feefo\Util
 */
class FeefoFtp
{

    /**
     * @var
     */
    private $server;
    /**
     * @var
     */
    private $username;
    /**
     * @var
     */
    private $password;
    /**
     * @var
     */
    private $connection;

    /**
     * FeefoFtp constructor.
     * @param $server
     * @param $username
     * @param $password
     */
    function __construct($server, $username, $password) {
        $this->server = $server;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     *
     */
    function openConnection() {
        $this->connection = ftp_connect($this->getServer());
    }

    /**
     *
     */
    function closeConnection() {
        ftp_close($this->getConnection());
    }

    /**
     * @return bool
     */
    function login() {
        return ftp_login($this->getConnection(), $this->getUsername(), $this->getPassword());
    }

    /**
     * @param $file
     * @return bool
     */
    function putFile($file) {

        $this->openConnection();

        $result = @ftp_put($this->getConnection(), $file, $file, FTP_ASCII);

        $this->closeConnection();

        return $result;

    }

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param mixed $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return mixed
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param mixed $server
     */
    public function setServer($server)
    {
        $this->server = $server;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}