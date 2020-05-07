<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Console;



use Psy\Configuration;
use Psy\Input\CodeArgument;
use Psy\Shell;
use BMamba\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShellCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'shell';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interactive Black Mamba console';

    /**
     * The console command help text.
     *
     * @var string
     */
    protected $help;

    protected function handle(InputInterface $input, OutputInterface $output) {
        $config = new Configuration([
            'updateCheck' => 'never',
//            'configFile' => realpath($raw = realpath(__DIR__.'/../config/tinker.php'))
        ]);

        $shell = new Shell($config);
        $shell->run();

        return 0;
    }
}