<?php

namespace Mizmoz\App\Contract;

use Mizmoz\Config\Contract\ConfigInterface;
use Mizmoz\Container\Contract\ContainerInterface;

interface AppHttpRegistrationInterface
{
    /**
     * Register the item with the application. This should be used by libraries such as the queue which will
     * need to register the queue management UI etc.
     *
     * @param HttpAppInterface $app
     * @param ContainerInterface $container
     * @param ConfigInterface $config
     */
    public function registerHttp(HttpAppInterface $app, ContainerInterface $container, ConfigInterface $config);
}