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
     * @var Application
     */
    protected $application;

    /**
     * @inheritDoc
     */
    public function addCommand(Command $command): AppInterface
    {
        if (! $this->application) {
            throw new AppNotReadyException('You must boot the app before you can add commands');
        }

        $this->application->add($command);
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
        call_user_func_array([$this->application, 'run'], func_get_args());

        return $this;
    }
}