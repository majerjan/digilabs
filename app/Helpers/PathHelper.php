<?php
declare(strict_types=1);

namespace App\Helpers;

use Nette\DI\Config\Loader;

class PathHelper {

    public static function getRoot(): string {
        return self::concatPath([__DIR__, '..', '..']);
    }

    public static function getApp(): string {
        return self::concatPath([self::getRoot(), 'app']);
    }

    public static function getSource(): string {
        return self::concatPath([self::getRoot(), 'source']);
    }

    public static function getTemp(): string {
        return self::concatPath([self::getRoot(), 'temp']);
    }

    public static function getConfig(): string {
        return self::concatPath([self::getRoot(), 'config']);
    }

    public static function getServerDomain(): string {
        $loader = new Loader();
        $content = $loader->load(PathHelper::concatPath([self::getConfig(), 'local.neon']));

        if (
            array_key_exists('parameters', $content) &&
            array_key_exists('host', $content['parameters'])
        ) {
            $domain = $content['parameters']['host'];
        } else {
            throw new \Exception();
        }

        return self::concatPath(['http://', $domain]);
    }

    public static function getServerDomainTemp(): string {
        return self::concatPath([self::getServerDomain(), 'temp']);
    }

    /**
     * @param string[] $pieces
     */
    public static function concatPath(array $pieces): string {
        return implode(DIRECTORY_SEPARATOR, $pieces);
    }
}