<?php
declare(strict_types=1);

namespace App\Resource;

use App\Exceptions\DataLoadingFailureException;
use App\Helpers\PathHelper;
use App\Resource\IDataResource;

class LocalResource implements IDataResource {

    /**
     * @throws DataLoadingFailureException
     */
    public function getData(): string {
        $data = file_get_contents(PathHelper::concatPath([PathHelper::getSource(), 'data.json']));

        if($data === false) {
            throw new DataLoadingFailureException();
        }

        return $data;
    }

    public function getImagePath(): string {
        $path = PathHelper::concatPath([PathHelper::getSource(), 'image.jpg']);

        if(!file_exists($path)) {
            throw new DataLoadingFailureException();
        }

        return $path;
    }
}