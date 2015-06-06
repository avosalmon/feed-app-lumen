<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    /**
     * Make response array out of input.
     *
     * @param  string $type
     * @param  array $data
     * @param  int $offset
     * @param  int $limit
     * @param  int $total
     * @return array
     */
    protected function formatResponse($type = 'data', $data = null, $offset = 0, $limit = 0, $total = 0)
    {
        return [
            $type  => $data,
            'meta' => [
                'offset' => $offset,
                'limit'  => $limit,
                'total'  => $total
            ]
        ];
    }

}
