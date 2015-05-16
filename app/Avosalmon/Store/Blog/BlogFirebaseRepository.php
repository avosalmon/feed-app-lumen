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
     * Create a new blog entry.
     *
     * @param  array $data
     * @return void
     */
    public function create($id, $data)
    {
        $this->firebase->set('blog/' . $id, $data);
    }

}