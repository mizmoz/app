<?php

namespace Mizmoz\App\Http;

use GuzzleHttp\Psr7\ServerRequest;
use Mizmoz\App\Contract\AppHttpRegistrationInterface;
use Mizmoz\App\Contract\AppInterface;
use Mizmoz\App\Contract\HttpAppInterface;
use Mizmoz\App\Exception\AppNotReadyException;
use Mizmoz\Router\Contract\DispatcherInterface;
use Mizmoz\Router\Contract\RouteInterface;
use Mizmoz\Router\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;

class App extends \Mizmoz\App\App implements HttpAppInterface
{
    /**
     * @var DispatcherInterface
     */
    private $dispatcher;

    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * @var RouteInterface
     */
    private $route;

    /**
     * @inheritdoc
     */
    public function register($register): AppInterface
    {
        if ($register instanceof AppHttpRegistrationInterface) {
            $register->registerHttp($this, $this->container, $this->config);
            return $this;
        }

        return parent::register($register);
    }

    /**
     * @inheritDoc
     */
    public function run(): AppInterface
    {
        // get the route file
        $dispatcher = $this->getDispatcher();

        // dispatch the request
        $response = $dispatcher->dispatch($this->getRequest());

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDispatcher(): DispatcherInterface
    {
        if (! $this->dispatcher) {
            $this->dispatcher = new Dispatcher($this->getRoute(), $this->container());
        }

        return $this->dispatcher;
    }

    /**
     * @inheritDoc
     */
    public function getRequest(): ServerRequestInterface
    {
        return ($this->request ? $this->request : ServerRequest::fromGlobals());
    }

    /**
     * @inheritDoc
     */
    public function getRoute(): RouteInterface
    {
        if (! $this->route) {
            throw new AppNotReadyException('App route must be set using setRoute() before running');
        }

        return $this->route;
    }

    /**
     * @inheritdoc
     */
    public function setDispatcher(DispatcherInterface $dispatcher): HttpAppInterface
    {
        $this->dispatcher = $dispatcher;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setRequest(ServerRequestInterface $request): HttpAppInterface
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setRoute(RouteInterface $route): HttpAppInterface
    {
        $this->route = $route;
        return $this;
    }
}