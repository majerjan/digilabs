<?php
declare(strict_types=1);

namespace App\Resource;

use App\Resource\IDataResource;
use Nette\Utils\FileSystem;

class ServerResource implements IDataResource {

    private const DATA_URL = 'https://www.digilabs.cz/hiring/data.php';
    private const IMAGE_URL = 'http://example.com/image.php';

    public function getData(): string {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::DATA_URL);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        $this->handleUnexpectedResponse($response);

        assert(is_string($response));
        return $response;
    }

    public function getImagePath(): string {
//        $file = FileSystem::open(__DIR__. '/../../source/image.jpg', 'w');
//        $ch = curl_init(self::IMAGE_URL);
//
//        curl_setopt($ch, CURLOPT_FILE, $file);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_exec($ch);
//        curl_close($ch);
//
//        return $file;
        return '';
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