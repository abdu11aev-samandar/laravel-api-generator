<?php

namespace UzInfo\LaravelApiGenerator\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Trait API response
 */
trait ApiResponse
{
    /**
     * @param string $message
     * @param array $data
     * @param  int $status
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    private function jsonResponse(string $message, array $data = [], int $status = 200)
    {
        return response([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $status
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    protected function replySuccess(string $message, array $data = [], int $status = 200)
    {
        return $this->jsonResponse($message, $data, $status);
    }

    /**
     * @param AnonymousResourceCollection $data
     * @param LengthAwarePaginator $items
     * @return \Illuminate\Http\Response
     */
    protected function replyPaginatedData(AnonymousResourceCollection $data, LengthAwarePaginator $items)
    {
        return response([
            'success'       => true,
            'data'          => $data,
            'total'         => $items->total(),
            'current_page'  => $items->currentPage(),
            'last_page'     => $items->lastPage(),
            'per_page'      => $items->perPage(),
        ]);
    }

    /**
     * @param AnonymousResourceCollection $data
     * @return \Illuminate\Http\Response
     */
    protected function replyUnpaginatedData(AnonymousResourceCollection $data)
    {
        return response([
            'success'       => true,
            'data'          => $data,
        ]);
    }

    /**
     * @param string $message
     * @param array $data
     * @param array $meta
     * @param int $status
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    protected function replyWithMeta(string $message, array $data = [], array $meta = [], int $status = 200)
    {
        return response([
            'success' => true,
            'data'    => $data,
            'meta'    => $meta,
            'message' => $message,
        ], $status);
    }

    /**
     * @param string $message
     * @param int $status
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    protected function replyFailure(string $message, array $data = [], int $status = 422)
    {
        return $this->jsonResponse($message, $data, $status);
    }

    /**
     * @param array $response
     * @param int $status
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function replyRaw(array $response, int $status = 200)
    {
        return response($response, $status);
    }
}
