<?php namespace App\Avosalmon\Store;

use r;

class Connection
{

    /**
     * RethinkDB connection.
     *
     * @var r\Connection
     */
    protected $connection;

    /**
     * Create a new instance.
     *
     * @param string  $host
     * @param integer $port
     * @param string  $database
     * @return void
     */
    public function __construct($host, $port, $database)
    {
        $this->connection = r\connect($host, $port, $database);
    }

    /**
     * Close db connection on destruction.
     *
     * @return void
     */
    public function __destruct()
    {
        $this->connection->close();
    }

    /**
     * Get RethinkDB connection.
     *
     * @return r\Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

}
