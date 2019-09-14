<?php

namespace elphis\Http;

use Swoole\Http\Response as SwooleResponse;

class Response
{
    protected $response;
    protected $headers;
    protected $cookie;
    protected $status;

    public function __construct($fd)
    {
        $this->response = SwooleResponse::create($fd);
    }

    public function json(array $body, int $status)
    {
        $this->contentType('application/json');
        $this->status($status);

        $this->send(\json_encode($body));
    }

    protected function send($body)
    {
        $this->response->status($this->status);

        foreach ($this->headers as $key => $value) {
            $this->response->header($key, $value);
        }

        foreach ($this->cookie as $key => $value) {
            $this->response->cookie($key, ...$value);
        }

        $this->response->end($body);
    }

    public function status($status)
    {
        $this->status = $status;
    }

    public function contentType($contentType)
    {
        $this->headers['Content-Type'] = $contentType;
    }

    public function cookie(string $key, string $value, int $expire = 0, string $path = '/', string $domain = '', bool $secure = false)
    {
        $this->cookie[$key] = [$value, $expire, $path, $domain, $secure];
    }
}
