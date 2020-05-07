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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class MakeProjectCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'makeproject';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new project';

    public function handle()
    {
        $path = 'E:/BMamba/src/Console/stubs/project';

        foreach ((new Finder)->in($path)->files() as $file) {

//            if($file->getRelativePath()) {
//                $path = $this->makeDirectory('E:/BMambaProject/' . $this->getNameInput() . '/' . $file->getRelativePath());
//            }
//
//            $name = ucfirst($this->getNameInput());
//            $stub = $this->files->get($file);
////
//            $stub = str_replace(
//                ['DummyNamespace'],
//                [$name],
//                $stub
//            );
//
//
//            $this->files->put('E:/BMambaProject/' . $this->getNameInput() . '/' . $file->getRelativePath() . str_replace('stub', 'php', $file->getFileName()), $stub);

        }
        return 0;
//        parent::handle();
    }



    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return ;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Resources';
    }


}