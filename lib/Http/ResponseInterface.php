<?php
namespace Http;

interface ResponseInterface
{
    /**
     * @return string
     */
    public function getBody();

    /**
     * @param string $body
     */
    public function setBody($body);

    /**
     * @return int
     */
    public function getStatusCode();

    /**
     * @param int $statusCode
     */
    public function setStatusCode($statusCode);

    /**
     * @return string
     */
    public function getContentType();

    /**
     * @param string $contentType
     */
    public function setContentType($contentType);

    /**
     * @param string $url
     */
    public function setRedirect($url);

    /**
     * @return boolean
     */
    public function isRedirect();

    /**
     * @return void
     */
    public function send();
}