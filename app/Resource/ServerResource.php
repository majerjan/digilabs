<?php
declare(strict_types=1);

namespace App\Resource;

use App\Helpers\PathHelper;
use Nette\Utils\FileSystem;


class ServerResource implements IDataResource {

    private const DATA_URL = 'https://www.digilabs.cz/hiring/data.php';
    private const IMAGE_URL = 'https://www.digilabs.cz/hiring/chuck.jpg';

    public function getData(): string {
        $ch = curl_init(self::DATA_URL);

        assert($ch instanceof \CurlHandle);

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        $this->handleUnexpectedResponse($response);

        assert(is_string($response));
        return $response;
    }

    public function getImagePath(): string {
        $path = PathHelper::concatPath([PathHelper::getTemp(), 'image.jpg']);
        $ch = curl_init(self::IMAGE_URL);

        assert($ch instanceof \CurlHandle);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $response = curl_exec($ch);

        curl_close($ch);

        $this->handleUnexpectedResponse($response);
        assert(is_string($response));

        FileSystem::write($path, $response);

        return $path;
    }


    private function handleUnexpectedResponse(bool|string $response): void {
        if($response === false) {
            throw new \Exception('false response');
        }

        if($response === true) {
            throw new \Exception('true response, missing string');
        }
    }
}