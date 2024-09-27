<?php

namespace Mizmoz\App\Contract;

use Mizmoz\Config\Contract\ConfigInterface;
use Mizmoz\Container\Contract\ContainerInterface;

interface AppCliRegistrationInterface
{
    /**
     * Register the item with the application. This should be used by libraries such as the queue which will
     * need to register the console commands and service providers for use in the app.
     *
     * @param CliAppInterface $app
     * @param ContainerInterface $container
     * @param ConfigInterface $config
     */
    public function registerCli(CliAppInterface $app, ContainerInterface $container, ConfigInterface $config): void;
}