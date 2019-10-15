<?php

namespace Elphis\Http;

use Swoole\Http\Response as SwooleResponse;

class Response
{
    /**
     * swoole response
     *
     * @var SwooleResponse
     */
    protected $response;

    /**
     * response headers array
     *
     * @var array
     */
    protected $headers = [];

    /**
     * response cookies array
     *
     * @var array
     */
    protected $cookie = [];

    /**
     * response status
     *
     * @var int
     */
    protected $status;

    public function __construct($fd)
    {
        $this->response = SwooleResponse::create($fd);
    }

    /**
     * send json response
     *
     * @param array $body
     * @param integer $status
     * @return void
     */
    public function json(array $body, int $status)
    {
        $this->contentType('application/json');
        $this->status($status);

        $this->send(json_encode($body));
    }

    /**
     * send response
     *
     * @param string $body
     * @return void
     */
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

    /**
     * set response status
     *
     * @param int $status
     * @return void
     */
    public function status($status)
    {
        $this->status = $status;
    }

    /**
     * set content type of response
     *
     * @param string $contentType
     * @return void
     */
    public function contentType($contentType)
    {
        $this->headers['Content-Type'] = $contentType;
    }

    /**
     * set response cookies
     *
     * @param string $key
     * @param string $value
     * @param integer $expire
     * @param string $path
     * @param string $domain
     * @param boolean $secure
     * @return void
     */
    public function cookie(string $key, string $value, int $expire = 0, string $path = '/', string $domain = '', bool $secure = false)
    {
        $this->cookie[$key] = [$value, $expire, $path, $domain, $secure];
    }
}
