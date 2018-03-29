<?php

namespace Mizmoz\App\Contract;

use Symfony\Component\Console\Command\Command;

interface CliAppInterface extends AppInterface
{
    /**
     * Add a command to the app
     *
     * @param Command $command
     * @return AppInterface
     */
    public function addCommand(Command $command): AppInterface;
}