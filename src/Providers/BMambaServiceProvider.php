<?php

namespace BMamba\Providers;

use BMamba\Console\CrawlCommand;
use BMamba\Console\GenspiderCommand;
use BMamba\Console\Kernel;
use BMamba\Console\MakeProjectCommand;
use BMamba\Console\ShellCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;;

class BMambaServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'Shell' => 'command.shell',
        'Crawl' => 'command.crawl',
        'Genspider' => 'command.genspider',
        'MakeProject' => 'command.make.project',
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands($this->commands);
    }

    /**
     * Register the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            call_user_func_array([$this, "register{$command}Command"], []);
        }

        $this->commands(array_values($commands));
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerShellCommand()
    {
        $this->app->singleton('command.shell', function ($app) {
            return new ShellCommand();
        });
    }

    protected function registerCrawlCommand()
    {
        $this->app->singleton('command.crawl', function ($app) {
            return new CrawlCommand();
        });
    }

    protected function registerGenspiderCommand()
    {
        $this->app->singleton('command.genspider', function ($app) {
            return new GenspiderCommand();
        });
    }

    protected function registerMakeProjectCommand()
    {
        $this->app->singleton('command.make.project', function ($app) {
            return new MakeProjectCommand(new Filesystem());
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_values($this->commands);
    }

    public function commands($commands)
    {
        $commands = is_array($commands) ? $commands : func_get_args();
        Kernel::starting(function ($artisan) use ($commands) {
            $artisan->resolveCommands($commands);
        });
    }
}
