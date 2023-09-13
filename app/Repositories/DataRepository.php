<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Dto\DataItemDto;
use App\Exceptions\InvalidNameException;
use App\Helpers\DataLoaderHelper;
use App\Helpers\StringHelper;
use App\Resource\IDataResource;

class DataRepository {

    public function __construct(
        private IDataResource    $resource,
        private DataLoaderHelper $dataDecoder,
        private StringHelper     $stringHelper
    ) {
    }

    public function getById(int $id) {
        $dataItems = $this->dataDecoder->load($this->resource);

        foreach ($dataItems as $item) {
            if($item->getId() === $id) return $item;
        }

        return null;
    }

    public function getRandomJoke(): DataItemDto {
        $dataItems = $this->dataDecoder->load($this->resource);
        $random = random_int(array_key_first($dataItems), array_key_last($dataItems));

        return $dataItems[$random];
    }

    /**
     * @return DataItemDto[]
     * @throws InvalidNameException
     */
    public function getSameFirstLetter(
        bool $onlyFirstName,
        bool $caseSensitive = true
    ): array {
        $out = [];
        $dataItems = $this->dataDecoder->load($this->resource);

        foreach ($dataItems as $item) {
            if($this->stringHelper->haveEqualNameSurnameChars(
                $dataItems[0]->getName(),
                $onlyFirstName,
                $caseSensitive
            )) {
                $out[] = $item;
            }
        }

        return $out;
    }

    /**
     * @return DataItemDto[]
     * @throws \Exception
     */
    public function getCountEqual(): array {
        $out = [];
        $dataItems = $this->dataDecoder->load($this->resource);

        foreach ($dataItems as $item) {
            if(
                $item->getSecondNumber() !== 0.0 &&
                $item->getFirstNumber() % 2 === 0 &&
                $item->getFirstNumber() / $item->getSecondNumber() === $item->getThirdNumber()
            ) {
                $out[] = $item;
            }
        }

        return $out;
    }

    /**
     * @return DataItemDto[]
     * @throws \Exception
     */
    public function getByMonth(): array {
        $out = [];
        $dataItems = $this->dataDecoder->load($this->resource);
        $now = new \DateTimeImmutable();
        $now->setTime(0,0,0);

        $from = $now->modify('-1 month');
        $to = $now->modify('+1 month');

        foreach ($dataItems as $item) {
            if($item->getCreatedAt() > $from && $item->getCreatedAt() < $to) {
                $out[] = $item;
            }
        }

        return $out;
    }

    /**
     * @return DataItemDto[]
     * @throws \Exception
     */
    public function getCalculation(): array {
        $out = [];
        $dataItems = $this->dataDecoder->load($this->resource);

        foreach ($dataItems as $item) {
            if($this->stringHelper->haveEqualEquation($item->getCalculation())) {
                $out[] = $item;
            }
        }

        return $out;
    }
}