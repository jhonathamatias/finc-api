<?php

namespace App\Infra;

use Psr\Http\Message\ResponseInterface;

class HttpResponse
{
    public function __construct(
        protected ResponseInterface $response,
    ) {}

    public function withJson(array $data, int $status = 200): ResponseInterface
    {
        $this->response->getBody()
            ->write(json_encode($data));

        return $this->response->withStatus($status);
    }
}
