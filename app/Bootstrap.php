<?php

declare(strict_types=1);

namespace App;

use App\Helpers\PathHelper;
use Nette\Bootstrap\Configurator;
use Nette\DI\Config\Loader;


class Bootstrap
{
	public static function boot(): Configurator
	{
        $loader = new Loader();
        $appDir = PathHelper::getRoot();
        $configDir = PathHelper::getConfig();
        $content = $loader->load(PathHelper::concatPath([$configDir, 'local.neon']));
		$configurator = new Configurator;

        if (
            array_key_exists('parameters', $content) &&
            array_key_exists('debugMode', $content['parameters'])
        ) {
            $configurator->setDebugMode($content['parameters']['debugMode']);
        }

		$configurator->enableTracy(PathHelper::concatPath([$appDir, 'log']));
		$configurator->setTempDirectory(PathHelper::concatPath([$appDir, 'temp']));

		$configurator->addConfig(PathHelper::concatPath([$configDir, 'common.neon']));
		$configurator->addConfig(PathHelper::concatPath([$configDir, 'services.neon']));

		return $configurator;
	}
}
