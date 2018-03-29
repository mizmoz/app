<?php

namespace Mizmoz\App\Tests;

use Mizmoz\App\Tests\Cli\App;
use Mizmoz\App\Contract\AppInterface;
use Mizmoz\App\Tests\Command\TestCommand;
use Mizmoz\Config\Contract\ConfigInterface;
use Mizmoz\Container\Contract\ContainerInterface;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;

class AppTest extends TestCase
{
    /**
     * Test basic CLI app creation
     */
    public function testCreateApp()
    {
        $app = App::create(__DIR__);
        $this->assertInstanceOf(AppInterface::class, $app);
        $this->assertInstanceOf(\Mizmoz\App\Cli\App::class, $app);
    }

    /**
     * Test we are loading the config from the config directory
     */
    public function testGetConfig()
    {
        $config = App::create(__DIR__)->config();
        $this->assertInstanceOf(ConfigInterface::class, $config);
        $this->assertSame('My App', $config->get('app.name'));
    }

    /**
     * Test we're given the Mizmoz\Container
     */
    public function testGetContainer()
    {
        $container = App::create(__DIR__)->container();
        $this->assertInstanceOf(ContainerInterface::class, $container);
    }

    /**
     * Test we can execute a console command
     */
    public function testExecuteConsoleCommand()
    {
        /** @var \Mizmoz\App\Cli\App $app */
        $app = App::create(__DIR__)->boot();

        // add the command
        $app->addCommand(new TestCommand());

        // run the app by simulating user input
        $input = new ArgvInput([
            'mizmoz',
            'test',
        ]);

        // stream to memory so we can see the output
        $output = new BufferedOutput();

        $app->run($input, $output);

        $this->assertSame('Executing test command.' . PHP_EOL, $output->fetch());
    }

    public function testMakeGlobal()
    {
        App::create(__DIR__)->makeGlobal()->boot();
        $this->assertInstanceOf(ContainerInterface::class, App::getInstance()->container());
    }
}