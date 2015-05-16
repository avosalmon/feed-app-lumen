<?php namespace App\Avosalmon\Store\Twitter;


interface TwitterRepositoryInterface
{

    /**
     * Create a new twitter entry.
     *
     * @param  array $data
     * @return void
     */
    public function create($id, $data);

}