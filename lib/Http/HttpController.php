<?php
namespace Http;

use \Http\RedirectResponse;
use \Http\RequestInterface;
use \Http\ResponseInterface;
use \Session\SessionInterface;
use \SplSubject;
use \SplObserver;
use \SplObjectStorage;

abstract class HttpController implements SplSubject
{
    /**
     * @var \Session\SessionInterface
     */
    protected $session;

    /**
     * @var \Http\Request
     */
    protected $request;

    /**
     * @var \Http\Response
     */
    protected $response;

    /**
     * @var \SplObjectStorage
     */
    protected $observers;

    /**
     * @var array
     */
    protected $results;

    /**
     * @param Connection $connection
     * @param SessionInterface $session
     * @param array $config
     */
    public function __construct(
        RequestInterface $request, ResponseInterface $response, SessionInterface $session
    )
    {
        $this->request = $request;
        $this->response = $response;
        $this->session = $session;
        $this->results = array();
        $this->observers = new SplObjectStorage();
    }

    /**
     * @return \Session\SessionInterface
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param \Session\SessionInterface $session
     */
    public function setSession(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @return \Http\RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param \Http\RequestInterface $request
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Http\ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param \Http\ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function addResult($key, $value)
    {
        $this->results[$key] = $value;
    }

    /**
     * @param \SplObserver $observer
     */
    public function attach(SplObserver $observer)
    {
        $this->observers->attach($observer);
    }

    /**
     * @param \SplObserver $observer
     */
    public function detach(SplObserver $observer)
    {
        $this->observers->detach($observer);
    }

    /**
     * Execute predispatch observers
     */
    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    /**
     * @param string $method
     * @return \Http\ResponseInterface
     */
    public function dispatch($method)
    {
        $this->notify();

        $this->$method();

        return $this->getResponse();
    }
}