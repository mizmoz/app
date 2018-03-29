<?php

namespace Mizmoz\App\Contract;

use Mizmoz\Config\Contract\ConfigInterface;
use Mizmoz\Container\Contract\ContainerInterface;

interface AppInterface extends \Psr\Container\ContainerInterface
{
    /**
     * AppInterface constructor.
     *
     * @param ContainerInterface $container
     * @param ConfigInterface $config
     */
    public function __construct(ContainerInterface $container, ConfigInterface $config);

    /**
     * Boot the application. This should be safe to call multiple times with the state being fully reset each time.
     * For instance this would be called between tests to reset the Application state
     *
     * @return AppInterface
     */
    public function boot(): AppInterface;

    /**
     * Get the config
     *
     * @return ConfigInterface
     */
    public function config(): ConfigInterface;

    /**
     * Get the container
     *
     * @return ContainerInterface
     */
    public function container(): ContainerInterface;

    /**
     * Make this app available globally using App
     *
     * @param bool $overwrite Overwrite any existing instance
     * @return AppInterface
     */
    public function makeGlobal(bool $overwrite = false): AppInterface;

    /**
     * Get the current platform
     *
     * @return string
     */
    public function platform(): string;

    /**
     * Add an item to register when the application boots
     *
     * @param AppRegistrationInterface|AppCliRegistrationInterface|AppHttpRegistrationInterface $register
     * @return AppInterface
     */
    public function register($register): AppInterface;

    /**
     * Run the application
     *
     * @return AppInterface
     */
    public function run(): AppInterface;

    /**
     * Get the global app instance
     *
     * @return AppInterface
     */
    public static function getInstance(): AppInterface;
}