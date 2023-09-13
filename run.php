<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$configurator = App\Bootstrap::boot();
$container = $configurator->createContainer();
$repo = $container->getByType(\App\Repositories\DataRepository::class);
$r = $container->getByType(\App\Resource\LocalResource::class);
$creator = $container->getByType(\App\Helpers\GifCreatorHelper::class);

assert($repo instanceof \App\Repositories\DataRepository);

$creator->createGifFromJpeg($r, $repo->getById(130));

