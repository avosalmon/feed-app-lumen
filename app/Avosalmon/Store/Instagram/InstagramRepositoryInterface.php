<?php namespace App\Avosalmon\Store\Instagram;


interface InstagramRepositoryInterface
{

    /**
     * Create a new instagram entry.
     *
     * @param  array $data
     * @return void
     */
    public function create($id, $data);

}