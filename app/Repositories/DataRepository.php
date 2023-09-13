<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Dto\DataItemDto;
use App\Exceptions\InvalidNameException;
use App\Helpers\DataLoaderHelper;
use App\Helpers\StringHelper;
use App\Resource\IDataResource;
use Tracy\Debugger;

class DataRepository {

    private const MAX_JOKE_LENGTH = 120;

    public function __construct(
        private readonly IDataResource    $resource,
        private readonly DataLoaderHelper $dataDecoder,
        private readonly StringHelper $stringHelper
    ) {
    }

    /**
     * @throws \Exception
     */
    public function getRandomJoke(): ?DataItemDto {
        $filtered = [];
        $dataItems = $this->dataDecoder->load($this->resource);

        foreach ($dataItems as $item) {
            if(mb_strlen($item->getJoke()) <= self::MAX_JOKE_LENGTH) {
                $filtered[] = $item;
            }
        }

        if(count($filtered) === 0) {
            return null;
        }

        $min = array_key_first($filtered);
        $max = array_key_last($filtered);

        assert(is_int($min));
        assert(is_int($max));
        assert($min <= $max);

        /** @phpstan-ignore-next-line */
        $random = random_int($min, $max);

        return $filtered[$random];
    }

    /**
     * @return DataItemDto[]
     * @throws InvalidNameException
     * @throws \Exception
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
        $now = (new \DateTimeImmutable())->setTime(0,0,0);

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