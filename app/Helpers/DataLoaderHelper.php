<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Dto\DataItemDto;
use App\Resource\IDataResource;
use PHPStan\Type\IterableType;

class DataLoaderHelper {

    /**
     * @return DataItemDto[]
     * @throws \Exception
     */
    public function load(IDataResource $resource): array {
        $out = [];
        $arr = json_decode($resource->getData(), true);

        assert(is_iterable($arr));

        foreach ($arr as $item) {
            $out[] = $this->convertToDataItem($item);
        }

        return $out;
    }

    /**
     * @param DataItemDto[] $items
     * @return array<int, array{
     *      id: int,
     *      name: string,
     *      firstNumber: float,
     *      secondNumber: float,
     *      thirdNumber: float,
     *      calculation: string,
     *      joke: string,
     *      createdAt: \DateTimeImmutable
     *  }>
     */
    public function convertToArray(array $items): array {
        $out = [];

        foreach ($items as $item) {
            $out[] = $item->toArray();
        }

        return $out;
    }

    /**
     * @param array{
     *       id: int,
     *       name: string,
     *       firstNumber: float,
     *       secondNumber: float,
     *       thirdNumber: float,
     *       calculation: string,
     *       joke: string,
     *       createdAt: string
     *   } $item
     * @return DataItemDto
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