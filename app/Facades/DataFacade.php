<?php
declare(strict_types=1);

namespace App\Facades;

use App\Exceptions\GifCreationException;
use App\Helpers\GifCreatorHelper;
use App\Helpers\PathHelper;
use App\Repositories\DataRepository;
use App\Resource\IDataResource;

class DataFacade {

    public function __construct(
        private readonly IDataResource $dataResource,
        private readonly DataRepository $dataRepository,
        private readonly GifCreatorHelper $gifCreatorHelper
    ) {
    }

    public function getJokeImagePath(): string {
        $item = $this->dataRepository->getRandomJoke();
        $path = $this->gifCreatorHelper->createGifFilePath($item->getId());

        if(file_exists($path) === false) {
            $create = $this->gifCreatorHelper->createGifFromJpeg($this->dataResource, $item);

            if($create === false) {
                throw new GifCreationException();
            }
        }

        return PathHelper::concatPath([
            PathHelper::getServerDomainTemp(),
            $this->gifCreatorHelper->createGifFileName($item->getId())
        ]);
    }
}