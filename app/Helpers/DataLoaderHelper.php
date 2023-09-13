<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Dto\DataItemDto;
use App\Resource\IDataResource;

class DataLoaderHelper {

    /**
     * @return DataItemDto[]
     * @throws \Exception
     */
    public function load(IDataResource $resource): array {
        $out = [];
        $arr = json_decode($resource->getData(), true);

        foreach ($arr as $item) {
            $out[] = $this->convertToDataItem($item);
        }

        return $out;
    }

    /**
     * @param DataItemDto[] $items
     */
    public function convertToArray(array $items) {
        $out = [];

        foreach ($items as $item) {
            $out[] = $item->toArray();
        }

        return $out;
    }

    /**
     * @throws \Exception
     */
    private function convertToDataItem(array $item): DataItemDto {
        return new DataItemDto(
            $item['id'],
            $item['name'],
            $item['firstNumber'],
            $item['secondNumber'],
            $item['thirdNumber'],
            $item['calculation'],
            $item['joke'],
            new \DateTimeImmutable($item['createdAt'])
        );
    }
}