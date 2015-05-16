<?php namespace App\Avosalmon\Store\Blog;


interface BlogRepositoryInterface
{

    /**
     * Create a new blog entry.
     *
     * @param  array $data
     * @return void
     */
    public function create($id, $data);

}