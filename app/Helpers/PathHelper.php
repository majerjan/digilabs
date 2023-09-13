<?php
declare(strict_types=1);

namespace App\Helpers;

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

    public static function getServerDomainTemp(): string {
        return self::concatPath(['http://localhost', 'temp']);
    }

    /**
     * @param string[] $pieces
     */
    public static function concatPath(array $pieces): string {
        return implode(DIRECTORY_SEPARATOR, $pieces);
    }
}