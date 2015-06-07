<?php namespace App\Avosalmon\Store\Blog;

use r;

class BlogRethinkdbRepository implements BlogRepositoryInterface
{

    /**
     * RethinkDB connection.
     *
     * @var
     */
    protected $conn;

    /**
     * Database host.
     *
     * @var string
     */
    protected $host;

    /**
     * Database port.
     *
     * @var integer
     */
    protected $port;

    /**
     * Database name.
     *
     * @var string
     */
    protected $database;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'blog';

    /**
     * Create a new instance.
     *
     * @param string  $host
     * @param integer $port
     * @param string  $database
     */
    public function __construct($host, $port, $database)
    {
        $this->host     = $host;
        $this->port     = $port;
        $this->database = $database;
    }

    /**
     * Create a db connection.
     *
     * @return void
     */
    protected function connect()
    {
        $this->conn = r\connect($this->host, $this->port, $this->database);
    }

    /**
     * Close a db connection.
     *
     * @return void
     */
    protected function close()
    {
        $this->conn->close();
    }

    /**
     * Get all blog entries.
     *
     * @param  int $offset
     * @param  int $limit
     * @param  bool $count
     * @return mixed
     */
    public function all($offset = 0, $limit = 20, $count = false)
    {
        $this->connect();

        if ($count) {
            $result = r\table($this->table)->count()->run($this->conn);
        } else {
            $result = r\table($this->table)->orderBy(['index' => r\desc('entry_date')])->skip($offset)->limit($limit)->run($this->conn)->toArray();
        }

        $this->close();

        return $result;
    }

    /**
     * Get single blog entry by id
     *
     * @param  int $id
     * @return mixed
     */
    public function find($id)
    {
        $this->connect();

        $result = r\table($this->table)->filter(['entry_id' => $id])->run($this->conn)->toArray();

        $this->close();

        return $result;
    }

    /**
     * Create a new blog entry.
     *
     * @param  array $data
     * @return void
     */
    public function create($data)
    {
        $this->connect();

        r\table($this->table)->insert($data)->run($this->conn);

        $this->close();
    }
}
