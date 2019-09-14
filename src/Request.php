<?php

namespace Elphis\Http;

class Request
{
    /**
     * stores query string of the request
     *
     * @var array
     */
    protected $get = [];

    /**
     * stres post data of the request
     *
     * @var array
     */
    protected $post = [];

    /**
     * stores raw content of the request
     *
     * @var string
     */
    protected $rawContent;

    /**
     * store the request headers
     *
     * @var array
     */
    protected $headers = [];

    /**
     * strores the parsed body of the request
     *
     * @var array
     */
    protected $parsedBody = [];

    /**
     * stores cookies of the request
     * 
     * @var array
     */
    protected $cookie;

    public function __construct(array $headers, array $get, array $post, array $cookie, $rawContent = null)
    {
        $this->get = $get;
        $this->post = $post;
        $this->cookie = $cookie;
        $this->rawContent = $rawContent;
        $this->setHeaders($headers);
        $this->body();
    }

    /**
     * check if the request expects json in return
     *
     * @return bool
     */
    public function expectsJson()
    {
        return $this->header('Accept') === 'application/json';
    }



    /**
     * get parsed request body
     *
     * @return array
     */
    public function body()
    {
        if ($this->parsedBody or $this->rawContent == null)
            return $this->parsedBody;

        if ($this->getContentType() == 'application/json')
            $this->parsedBody = json_decode($this->rawContent, true);

        elseif ($this->getContentType() == 'application/x-www-formurlencoded')
            $this->parsedBody = parse_str($this->rawContent);

        return $this->parsedBody;
    }

    /**
     * get request data by the key
     *
     * @param string|null $key
     * @return array|string|null
     */
    public function get(string $key = null)
    {
        $body = $this->all();
        if (!$key)
            return $body;

        if (array_key_exists($key, $body))
            return $body[$key];

        return null;
    }

    /**
     * get cookie from the request
     *
     * @param string $key
     * @return void
     */
    public function cookie(string $key)
    {
        if (array_key_exists($key, $this->cookie))
            return $this->cookie[$key];

        return null;
    }

    /**
     * get all request data
     *
     * @return array
     */
    public function all()
    {
        $body = array_merge($this->get, $this->post, $this->parsedBody);

        if (!$body)
            $body = [];

        return $body;
    }

    /**
     * get request method
     *
     * @return string
     */
    public function method()
    {
        return $this->header('REQUEST_METHOD');
    }

    /**
     * get request uri
     *
     * @return string
     */
    public function uri()
    {
        return $this->header('REQUEST_URI');
    }

    /**
     * get contnet type of the request
     *
     * @return string
     */
    public function contentType()
    {
        return $this->header('Content-Type');
    }

    protected function explodeHeader($header)
    {
        $headerParts = explode('_', $header);
        array_map('strtolower', $headerParts);
        $headerKey = ucwords(
            implode(
                ' ',
                $headerParts
            )
        );

        return str_replace(' ', '-', $headerKey);
    }

    protected function setHeaders(array $headers)
    {
        $headers = [];
        foreach ($this->headers as $key => $value) {

            if (stripos($key, 'HTTP_') !== FALSE) {

                $headerKey = str_ireplace('HTTP_', '', $key);
                $headers[$this->explodeHeader($headerKey)] = $value;
            } elseif (stripos($key, 'CONTENT_') !== FALSE) {

                $headers[$this->explodeHeader($key)] = $value;
            }
        }

        $this->headers = $headers;
    }

    /**
     * get request headers
     *
     * @return array
     */
    public function headers()
    {
        return $this->headers;
    }

    /**
     * get request header by the key
     *
     * @param string $key
     * @return void
     */
    public function header(string $key)
    {
        return $this->headers[$key];
    }
}
