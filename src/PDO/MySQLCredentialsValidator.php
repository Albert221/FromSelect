<?php

namespace FromSelect\PDO;

use PDOException;

class MySQLCredentialsValidator
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * CredentialsValidator constructor.
     *
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string $password
     */
    public function __construct($host, $port = 3306, $username = '', $password = '')
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Validated given to constructor credentials and returns true if they
     * are okay.
     *
     * @return bool
     */
    public function validate()
    {
        try {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;charset=utf8',
                $this->host,
                $this->port
            );
            new PDO($dsn, $this->username, $this->password);
        } catch (PDOException $e) {
            return false;
        }

        return true;
    }
}
