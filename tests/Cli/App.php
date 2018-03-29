<?php

namespace Mizmoz\App\Tests\Cli;

use Mizmoz\App\Contract\AppInterface;
use Mizmoz\App\Contract\CliAppInterface;

class App extends \Mizmoz\App\Cli\App implements CliAppInterface
{
    /**
     * @inheritdoc
     */
    public function boot(): AppInterface
    {
        return parent::boot();
    }
}