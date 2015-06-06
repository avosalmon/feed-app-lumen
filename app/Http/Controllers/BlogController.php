<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kurashicom\Response\ResponseHandler;
use App\Avosalmon\Store\Blog\BlogRepositoryInterface;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{

    /**
     * Variable to hold the instance of the injected dependency.
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * Variable to hold the instance of the injected dependency.
     *
     * @var App\Avosalmon\Store\Blog\BlogRepositoryInterface
     */
    protected $blog;

    /**
     * Variable to hold the instance of the injected dependency.
     *
     * @var Kurashicom\Response\ResponseHandler
     */
    protected $response;

    /**
     * Create a new instance.
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\Avosalmon\Store\Blog\BlogRepositoryInterface $blog
     * @param  Kurashicom\Response\ResponseHandler $response
     * @return void
     */
    public function __construct(Request $request, BlogRepositoryInterface $blog, ResponseHandler $response)
    {
        $this->request  = $request;
        $this->blog     = $blog;
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $offset  = (int)$this->request->input('offset', 0);
        $limit   = (int)$this->request->input('limit', 20);
        $type    = 'blog';
        $entries = $this->blog->all($offset, $limit);
        $total   = $this->blog->all($offset, $limit, $count = true);

        return $this->response->success($this->formatResponse($type, $entries, $offset, $limit, $total));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $type   = 'blog';
        $entry  = $this->blog->find($id);
        $offset = 0;
        $limit  = 1;
        $total  = $entry === null ? 0 : 1;

        if ($entry) return $this->response->success($this->formatResponse($type, $entry, $offset, $limit, $total));

        return $this->response->error('', 404);
    }

}
