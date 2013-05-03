<?php
namespace Http;

use \Utils\Map;

class Request implements RequestInterface
{
    /**
     * @var \Utils\Map
     */
    protected $post;

    /**
     * @var \Utils\Map
     */
    protected $query;

    /**
     * @var \Utils\Map
     */
    protected $server;

    /**
     * @param array $post
     * @param array $query
     * @param array $server
     */
    public function __construct(array $post = array(), array $query = array(), array $server = array())
    {
        if (empty($post)) {
            $post = $_POST;
        }

        if (empty($query)) {
            $query = $_GET;
        }

        if (empty($server)) {
            $server = $_SERVER;
        }

        $this->post = new Map($post);
        $this->query = new Map($query);
        $this->server = new Map($server);
    }

    /**
     * @return \Utils\Map
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param \Utils\Map $post
     */
    public function setPost(Map $post)
    {
        $this->post = $post;
    }

    /**
     * @return \Utils\Map
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param \Utils\Map $query
     */
    public function setQuery(Map $query)
    {
        $this->query = $query;
    }

    /**
     * @return \Utils\Map
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param \Utils\Map $server
     */
    public function setServer(Map $server)
    {
        $this->server = $server;
    }

    /**
     * @return boolean
     */
    public function isPost()
    {
        return 'POST' === $this->getServer()->get('REQUEST_METHOD');
    }
}