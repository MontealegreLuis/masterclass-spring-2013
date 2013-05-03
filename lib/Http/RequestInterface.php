<?php
namespace Http;

use \Utils\Map;

interface RequestInterface
{
    /**
     * @return \Utils\Map
     */
    public function getPost();

    /**
     * @param \Utils\Map $post
     */
    public function setPost(Map $post);
    /**
     * @return \Utils\Map
     */
    public function getQuery();

    /**
     * @param \Utils\Map $query
     */
    public function setQuery(Map $query);

    /**
     * @return \Utils\Map
     */
    public function getServer();

    /**
     * @param \Utils\Map $server
     */
    public function setServer(Map $server);

    /**
     * @return boolean
     */
    public function isPost();
}