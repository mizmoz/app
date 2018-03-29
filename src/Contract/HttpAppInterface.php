<?php

namespace Mizmoz\App\Contract;

use Mizmoz\Router\Contract\DispatcherInterface;
use Mizmoz\Router\Contract\RouteInterface;
use Psr\Http\Message\ServerRequestInterface;

interface HttpAppInterface extends AppInterface
{
    /**
     * Get the dispatcher
     *
     * @return DispatcherInterface
     */
    public function getDispatcher(): DispatcherInterface;

    /**
     * Get the request object
     *
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface;

    /**
     * Get the app's parent route
     *
     * @return RouteInterface
     */
    public function getRoute(): RouteInterface;

    /**
     * Set the dispatcher
     *
     * @param DispatcherInterface $dispatcher
     * @return HttpAppInterface
     */
    public function setDispatcher(DispatcherInterface $dispatcher): HttpAppInterface;

    /**
     * Set the request object
     *
     * @param ServerRequestInterface $request
     * @return HttpAppInterface
     */
    public function setRequest(ServerRequestInterface $request): HttpAppInterface;

    /**
     * Set the app's parent route
     *
     * @param RouteInterface $route
     * @return HttpAppInterface
     */
    public function setRoute(RouteInterface $route): HttpAppInterface;
}