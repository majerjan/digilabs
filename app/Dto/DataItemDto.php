<?php
declare(strict_types=1);

namespace App\Dto;

 class DataItemDto {

    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly float $firstNumber,
        private readonly float $secondNumber,
        private readonly float $thirdNumber,
        private readonly string $calculation,
        private readonly string $joke,
        private readonly \DateTimeImmutable $createdAt
    ) {
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getFirstNumber(): float {
        return $this->firstNumber;
    }

    public function getSecondNumber(): float {
        return $this->secondNumber;
    }

    public function getThirdNumber(): float {
        return $this->thirdNumber;
    }

    public function getCalculation(): string {
        return $this->calculation;
    }

    public function getJoke(): string {
        return $this->joke;
    }

    public function getCreatedAt(): \DateTimeImmutable {
        return $this->createdAt;
    }

     /**
      * @return array{
      *     id: int,
      *     name: string,
      *     firstNumber: float,
      *     secondNumber: float,
      *     thirdNumber: float,
      *     calculation: string,
      *     joke: string,
      *     createdAt: \DateTimeImmutable
      * }
      */
     public function toArray(): array {
         return [
             'id' => $this->getId(),
             'name' => $this->getName(),
             'firstNumber' => $this->getFirstNumber(),
             'secondNumber' => $this->getSecondNumber(),
             'thirdNumber' => $this->getThirdNumber(),
             'calculation' => $this->getCalculation(),
             'joke' => $this->getJoke(),
             'createdAt' => $this->getCreatedAt()
         ];
    }
}