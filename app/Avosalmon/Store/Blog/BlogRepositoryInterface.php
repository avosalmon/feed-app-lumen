<?php namespace App\Avosalmon\Store\Blog;

interface BlogRepositoryInterface
{
    /**
     * Get all blog entries.
     *
     * @param  int $offset
     * @param  int $limit
     * @param  bool $count
     * @return int|array
     */
    public function all($offset = 0, $limit = 10, $count = false);

    /**
     * Get single blog entry by id
     *
     * @param  int $id
     * @return array
     */
    public function find($id);

    /**
     * Create a new blog entry.
     *
     * @param  array $data
     * @return r\Cursor
     */
    public function create($data);

}
