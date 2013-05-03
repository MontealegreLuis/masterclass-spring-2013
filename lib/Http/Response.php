<?php
namespace Http;

class Response implements ResponseInterface
{
    /**
     * @var string
     */
    protected $body;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string
     */
    protected $contentType;

    /**
     * @var string
     */
    protected $url;

    /**
     * Set default values
     */
    public function __construct()
    {
        $this->setStatusCode(200);
        $this->setContentType('text/html');
    }

    /**
     * @return string
     */
    protected function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * @see \Http\ResponseInterface::setRedirect()
     */
    public function setRedirect($url)
    {
        $this->url = $url;
    }

    /**
     * @see \Http\ResponseInterface::isRedirect()
     */
    public function isRedirect()
    {
        return !empty($this->url);
    }

    /**
     * @return void
     */
    public function send()
    {
        if ($this->isRedirect()) {

            header("Location: {$this->getUrl()}");

            return;
        }

        http_response_code($this->getStatusCode());
        header("Content-type: {$this->getContentType()}");

        echo $this->getBody();
    }
}