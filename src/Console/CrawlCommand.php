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

class CrawlCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl a website';

    /**
     * The console command help text.
     *
     * @var string
     */
    protected $help;


//    protected function configure()
//    {
//        $this
//            ->setName('crawl')
//            ->setDescription('Crawl a website')
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


    public function handle() {

        return 0;
    }
}