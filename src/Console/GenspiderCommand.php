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

class GenspiderCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'genspider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new spider using pre-defined templates';

    /**
     * The console command help text.
     *
     * @var string
     */
    protected $help;


//    protected function configure()
//    {
//        $this
//            ->setName('genspider')
//            ->setDescription('Generate new spider using pre-defined templates')
//            ->setHelp(
//                <<<'HELP'
//Dump an object or primitive.
//
//This is like var_dump but <strong>way</strong> awesomer.
//
//e.g.
//<return>>>> fetch url </return>
//HELP
//            );
//    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $config = new Configuration([
            'updateCheck' => 'never',
            'configFile' => realpath($raw = realpath(__DIR__.'/../config/tinker.php'))
        ]);

        $shell = new Shell($config);
        $shell->run();
    }
}