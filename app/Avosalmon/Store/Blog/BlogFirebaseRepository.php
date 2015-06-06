<?php namespace App\Avosalmon\Store\Blog;

use Firebase\FirebaseLib;

class BlogFirebaseRepository implements BlogRepositoryInterface
{

    /**
     * Variable to hold the instance of the injected dependency.
     *
     * @var Firebase\FirebaseLib
     */
    protected $firebase;

    /**
     * Create new instances for dependencies.
     *
     * @param Firebase\FirebaseLib $firebase
     * @return void
     */
    public function __construct(FirebaseLib $firebase)
    {
        $this->firebase = $firebase;
    }

    /**
     * Get all blog entries.
     *
     * @param  int $offset
     * @param  int $limit
     * @param  bool $count
     * @return mixed
     */
    public function all($offset = 0, $limit = 10, $count = false)
    {

    }

    /**
     * Get single blog entry by id
     *
     * @param  int $id
     * @return mixed
     */
    public function find($id)
    {

    }

    /**
     * Create a new blog entry.
     *
     * @param  array $data
     * @return void
     */
    public function create($data)
    {
        // $this->firebase->set('blog/' . $id, $data);
    }

}