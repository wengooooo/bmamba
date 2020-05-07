<?php

namespace BMamba;

use BMamba\Contracts\Container\CrawlerContainer;
use BMamba\Settings\LoadSettings;
use BMamba\Container\BMambaContainer;

use Illuminate\Support\Arr;
use BMamba\Container\BMambaServiceProvider as ServiceProvider;
use Illuminate\Support\Str;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

class Application extends BMambaContainer
{
    const VERSION = '0.1';

    protected $booted = false;

    protected $serviceProviders = [];

    protected $loadedProviders = [];

    protected $deferredServices = [];

    protected $basePath;

    protected $appPath;

    protected $namespace;

    protected $coreServiceProviders = [

    ];

    public function __construct($basePath = null) {

        if ($basePath) {
            $this->setBasePath($basePath);
        }

        $this->registerBaseBindings();
        $this->registerCoreContainerAliases();
        $this->registerServiceProviders();
        $this->loadSettings();

    }

    protected function registerBaseBindings()
    {
        static::setInstance($this);

        $this->instance('app', $this);

        $this->instance(CrawlerContainer::class, $this);

    }

    public function registerCoreContainerAliases()
    {
        foreach ([
                     'app'                  => [self::class, \BMamba\Contracts\Container\CrawlerContainer::class, \Psr\Container\ContainerInterface::class],
//                     'engine'               => [\BMamba\Contracts\Engine\IEngine::class],
//                     'downloader'           => [\BMamba\Downloader\Downloader::class],
//                     'scheduler'            => [\BMamba\Scheduler\Scheduler::class],
//                     'spiders'              => [\BMamba\Spiders\CrawlSpider::class],
//                     'spider.loader'        => [\BMamba\Contracts\SpiderLoader\ISpiderLoader::class],
////                     'http.client'          => [\BMamba\HttpClient\HttpClient::class],
//                     'pipelines'            => [\BMamba\Pipelines\ItemPipelineManager::class],
                 ] as $key => $aliases) {
            foreach ($aliases as $alias) {
                $this->alias($key, $alias);
            }
        }
    }

    /**
     * 注册所有核心的服务提供者
     *
     * @return void
     */
    protected function registerServiceProviders()
    {
        $namespace = $this->getNamespace();
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'Providers';

        foreach ((new Finder)->in($path)->files() as $provider) {
            $provider = $namespace.'Providers\\'.str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($provider->getPathname(), $path.DIRECTORY_SEPARATOR)
                );

            if (is_subclass_of($provider, ServiceProvider::class) &&
                ! (new ReflectionClass($provider))->isAbstract()) {
                $this->register(new $provider($this));
            }
        }
    }

    public function basePath($path = '')
    {
        return $this->basePath.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function path($path = '')
    {
        $appPath = $this->appPath ?: $this->basePath.DIRECTORY_SEPARATOR.'src';

        return $appPath.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function getNamespace()
    {
        if (! is_null($this->namespace)) {
            return $this->namespace;
        }

        $composer = json_decode(file_get_contents($this->basePath('composer.json')), true);

        foreach ((array) data_get($composer, 'autoload.psr-4') as $namespace => $path) {
            foreach ((array) $path as $pathChoice) {
                if (realpath($this->path()) === realpath($this->basePath($pathChoice))) {
                    return $this->namespace = $namespace;
                }
            }
        }
//
//        throw new RuntimeException('Unable to detect application namespace.');
    }

    public function bootstrapWith(array $bootstrappers)
    {
        $this->hasBeenBootstrapped = true;

        foreach ($bootstrappers as $bootstrapper) {

            $this->make($bootstrapper)->bootstrap($this);

        }
    }

    public function getProvider($provider)
    {
        return array_values($this->getProviders($provider))[0] ?? null;
    }

    public function register($provider, $force = false)
    {
        if (($registered = $this->getProvider($provider)) && ! $force) {
            return $registered;
        }

        // If the given "provider" is a string, we will resolve it, passing in the
        // application instance automatically for the developer. This is simply
        // a more convenient way of specifying your service provider classes.
        if (is_string($provider)) {
            $provider = $this->resolveProvider($provider);
        }

        $provider->register();

        // If there are bindings / singletons set as properties on the provider we
        // will spin through them and register them with the application, which
        // serves as a convenience layer while registering a lot of bindings.
        if (property_exists($provider, 'bindings')) {
            foreach ($provider->bindings as $key => $value) {
                $this->bind($key, $value);
            }
        }

        if (property_exists($provider, 'singletons')) {
            foreach ($provider->singletons as $key => $value) {
                $this->singleton($key, $value);
            }
        }

        $this->markAsRegistered($provider);

        // If the application has already booted, we will call this boot method on
        // the provider class so it has an opportunity to do its boot logic and
        // will be ready for any usage by this developer's application logic.
        if ($this->isBooted()) {
            $this->bootProvider($provider);
        }

        return $provider;
    }

    protected function bootProvider(ServiceProvider $provider)
    {
        if (method_exists($provider, 'boot')) {
            return $this->call([$provider, 'boot']);
        }
    }

    public function resolveProvider($provider)
    {
        return new $provider($this);
    }

    protected function markAsRegistered($provider)
    {
        $this->serviceProviders[] = $provider;

        $this->loadedProviders[get_class($provider)] = true;
    }

    public function isBooted()
    {
        return $this->booted;
    }

    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');

        return $this;
    }

    public function getBasePath() {
        return $this->basePath;
    }

    public function configPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'settings.php';
    }

    public function getProviders($provider)
    {
        $name = is_string($provider) ? $provider : get_class($provider);

        return Arr::where($this->serviceProviders, function ($value) use ($name) {
            return $value instanceof $name;
        });
    }

    public function loadSettings() {
        $this->make(LoadSettings::class)->load($this);
    }

    public function getServiceProviders() {
        return array_keys($this->loadedProviders);
    }
    public function version()
    {
        return static::VERSION;
    }


}