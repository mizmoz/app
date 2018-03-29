<?php

namespace Mizmoz\App;

use Mizmoz\App\Contract\AppInterface;
use Mizmoz\App\Contract\AppRegistrationInterface;
use Mizmoz\App\Exception\InvalidArgumentException;
use Mizmoz\App\Exception\RuntimeException;
use Mizmoz\Config\Config;
use Mizmoz\Config\Contract\ConfigInterface;
use Mizmoz\Config\Environment;
use Mizmoz\Container\Container;
use Mizmoz\Container\Contract\ContainerInterface;
use Mizmoz\Container\Resolver;
use Tracy\Debugger;

abstract class App implements AppInterface
{
    /**
     * @var AppInterface
     */
    protected static $instance;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @inheritdoc
     */
    public function __construct(ContainerInterface $container, ConfigInterface $config)
    {
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * Create the application with all the default setup
     *
     * @param string $projectRoot
     * @param string $configDirectory
     * @param string $environment
     * @return AppInterface
     */
    public static function create(
        string $projectRoot,
        string $configDirectory = './config',
        string $environment = null
    ): AppInterface
    {
        // get the environment
        $environment = (
            $environment ? new Environment($environment, $projectRoot) : Environment::create($projectRoot)
        );

        // create the configs from the config directory
        $config = Config::fromEnvironment($environment, $configDirectory);

        // create a new container
        $container = new Container(new Resolver());

        // add the config to the container
        $container->addValue('config', $config);

        // create the app
        return new static($container, $config);
    }

    /**
     * Are we running on the command line?
     *
     * @return bool
     */
    public static function isCli(): bool
    {
        return (php_sapi_name() === 'cli');
    }

    /**
     * @inheritDoc
     */
    public function boot(): AppInterface
    {
        // init the error reporting
        if ($this->config()->get('app.debugger.enable')) {
            $platform = ($this->platform() === Environment::ENV_PRODUCTION ? Debugger::PRODUCTION : Debugger::DEVELOPMENT);
            Debugger::enable($platform);

            // set PHPStorm as the editor
            Debugger::$editor = $this->config()->get('app.debugger.editor');
            Debugger::$editorMapping = $this->config()->get('app.debugger.editorMapping');
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function config(): ConfigInterface
    {
        return $this->config;
    }

    /**
     * @inheritdoc
     */
    public function container(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @inheritDoc
     */
    public function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * @inheritDoc
     */
    public function has($id)
    {
        return $this->container->has($id);
    }

    /**
     * @inheritDoc
     */
    public function register($register): AppInterface
    {
        if ($register instanceof AppRegistrationInterface) {
            $register->register($this->container, $this->config);
            return $this;
        }

        throw new InvalidArgumentException('$register must implement one of the App*RegistrationInterfaces');
    }

    /**
     * @inheritdoc
     */
    public function makeGlobal(bool $overwrite = false): AppInterface
    {
        if (! $overwrite && self::$instance) {
            throw new RuntimeException('An App has already been made global');
        }

        return self::$instance = $this;
    }

    /**
     * @inheritDoc
     */
    public function platform(): string
    {
        return $this->config()->get('environment.name');
    }

    /**
     * Get the global app instance
     *
     * @return AppInterface
     */
    public static function getInstance(): AppInterface
    {
        if (! static::$instance) {
            throw new RuntimeException('No global App has been set, call makeGlobal() on an App instance first.');
        }

        return self::$instance;
    }
}