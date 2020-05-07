<?php

namespace BMamba\Providers;

use BMamba\Logger\Logger;
use BMamba\Contracts\Container\CrawlerContainer as Container;
use BMamba\Container\BMambaServiceProvider as ServiceProvider;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class LoggerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('log', function (Container $container) {
            $outputFormatter = new OutputFormatter(true, [
                'date' => new OutputFormatterStyle('white', 'black'),
                'component' => new OutputFormatterStyle('green', 'black'),
                'level' => new OutputFormatterStyle('yellow', 'black'),
                'message' => new OutputFormatterStyle('white', 'black'),
                'module_name' => new OutputFormatterStyle('cyan', 'black'),

            ]);
            $output = new ConsoleOutput(OutputInterface::VERBOSITY_DEBUG, null, $outputFormatter);
            return new Logger($output);
        });
    }
}
