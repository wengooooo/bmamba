<?php

namespace BMamba\Settings;


use BMamba\Contracts\Container\CrawlerContainer;
use Illuminate\Config\Repository;

class LoadSettings
{
    public function __construct()
    {

    }

    public function load(CrawlerContainer $app) {
        $items = [];

        $app->instance('config', $config = new Repository($items));

        $defaultSettings = $customSettings = require "defaultSettings.php";

        if(file_exists($app->configPath())) {
            $customSettings = require_once $app->configPath();
        }

        $settings = array_merge($defaultSettings, $customSettings);

        $config->set("settings", $settings);

    }
}