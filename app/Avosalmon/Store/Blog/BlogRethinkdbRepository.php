<?php namespace App\Avosalmon\Store\Blog;

use r;
use App\Avosalmon\Store\Connection;

class BlogRethinkdbRepository implements BlogRepositoryInterface
{

    /**
     * Variable to hold the instance of the injected dependency.
     *
     * @var App\Avosalmon\Store\Connection
     */
    protected $conn;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'blog';

    /**
     * Create a new instance.
     *
     * @param  App\Avosalmon\Store\Connection
     * @return void
     */
    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Get RethinkDB connection.
     *
     * @return r\Connection
     */
    protected function getConnection()
    {
        return $this->conn->getConnection();
    }

    /**
     * Get all blog entries.
     *
     * @param  int $offset
     * @param  int $limit
     * @param  bool $count
     * @return int|array
     */
    public function all($offset = 0, $limit = 20, $count = false)
    {
        if ($count) return r\table($this->table)->count()->run($this->getConnection());

        return r\table($this->table)->orderBy(['index' => r\desc('entry_date')])->skip($offset)->limit($limit)->run($this->getConnection())->toArray();
    }

    /**
     * Get single blog entry by id
     *
     * @param  int $id
     * @return array
     */
    public function find($id)
    {
        return r\table($this->table)->filter(['entry_id' => $id])->run($this->getConnection())->toArray();
    }

    /**
     * Create a new blog entry.
     *
     * @param  array $data
     * @return r\Cursor
     */
    public function create($data)
    {
        return r\table($this->table)->insert($data)->run($this->getConnection());
    }

}
