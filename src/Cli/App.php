<?php

namespace Mizmoz\App\Cli;

use Mizmoz\App\Contract\AppCliRegistrationInterface;
use Mizmoz\App\Contract\AppInterface;
use Mizmoz\App\Contract\CliAppInterface;
use Mizmoz\App\Exception\AppNotReadyException;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

class App extends \Mizmoz\App\App implements CliAppInterface
{
    /**
     * @var ?Application
     */
    protected ?Application $application = null;

    /**
     * Use the application instance, will throw an exception if the application is not ready
     *
     * @return Application
     */
    private function useApplication(): Application
    {
        if (! $this->application) {
            throw new AppNotReadyException('You must boot the app before you can use the application');
        }

        return $this->application;
    }

    /**
     * @inheritDoc
     */
    public function addCommand(Command $command): AppInterface
    {
        $this->useApplication()->add($command);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function boot(): AppInterface
    {
        // create the symfony console application
        $this->application = new Application();

        // dont auto exit
        $this->application->setAutoExit(false);

        // boot the parent
        return parent::boot();
    }

    /**
     * @inheritdoc
     */
    public function register($register): AppInterface
    {
        if ($register instanceof AppCliRegistrationInterface) {
            $register->registerCli($this, $this->container, $this->config);
            return $this;
        }

        return parent::register($register);
    }

    /**
     * @inheritDoc
     */
    public function run(): AppInterface
    {
        // allow input & output to be passed for testing
        call_user_func_array([$this->useApplication(), 'run'], func_get_args());

        return $this;
    }
}