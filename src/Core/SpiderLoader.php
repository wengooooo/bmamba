<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Core;


use BMamba\Contracts\Container\CrawlerContainer;
use BMamba\Traits\WithMagicFunction;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use \BMamba\Contracts\Core\SpiderLoader as SpiderLoaderContract;

class SpiderLoader implements SpiderLoaderContract
{
    use WithMagicFunction;

    private $spiders = [];
    protected $container;

    public function __construct(CrawlerContainer $container)
    {
        $this->container = $container;
        $this->loadAllSpiders();
    }

    private function loadSpiders($name, $spiderCls) {
        $this->spiders[$name] = $this->container->make($spiderCls);
    }

    private function getClassFromFile($file)
        {
            //Grab the contents of the file
            $contents = file_get_contents($file);

            //Start with a blank namespace and class
            $namespace = $class = "";

            //Set helper values to know that we have found the namespace/class token and need to collect the string values after them
            $getting_namespace = $getting_class = false;

            //Go through each token and evaluate it as necessary
            foreach (token_get_all($contents) as $token) {

                //If this token is the namespace declaring, then flag that the next tokens will be the namespace name
                if (is_array($token) && $token[0] == T_NAMESPACE) {
                    $getting_namespace = true;
                }

                //If this token is the class declaring, then flag that the next tokens will be the class name
                if (is_array($token) && $token[0] == T_CLASS) {
                    $getting_class = true;
                }

                //While we're grabbing the namespace name...
                if ($getting_namespace === true) {

                    //If the token is a string or the namespace separator...
                    if(is_array($token) && in_array($token[0], [T_STRING, T_NS_SEPARATOR])) {

                        //Append the token's value to the name of the namespace
                        $namespace .= $token[1];

                    }
                    else if ($token === ';') {

                        //If the token is the semicolon, then we're done with the namespace declaration
                        $getting_namespace = false;

                    }
                }

                //While we're grabbing the class name...
                if ($getting_class === true) {

                    //If the token is a string, it's the name of the class
                    if(is_array($token) && $token[0] == T_STRING) {

                        //Store the token's value as the class name
                        $class = $token[1];

                        //Got what we need, stope here
                        break;
                    }
                }
            }

            //Build the fully-qualified class name and return it
            return $namespace ? $namespace . '\\' . $class : $class;

        }

    public function loadAllSpiders() {
        foreach($this->config->get('settings.SPIDER_MODULES') as $name) {
            $configPath = $this->container->getBasePath() . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $name);
            foreach (Finder::create()->files()->name('*.php')->in($configPath) as $file) {
                $directory = $this->getNestedDirectory($file, $configPath);
                $spiderCls = $this->getClassFromFile($file->getRealPath());
                $this->loadSpiders($directory.basename($file->getRealPath(), '.php'), $spiderCls);
            }
        }
    }

    protected function getNestedDirectory(SplFileInfo $file, $configPath)
    {
        $directory = $file->getPath();

        if ($nested = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR)) {
            $nested = str_replace(DIRECTORY_SEPARATOR, '.', $nested).'.';
        }

        return $nested;
    }

    public function load($spiderName) {
        return $this->spiders[$spiderName];
    }

}