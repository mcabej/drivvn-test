<?php

namespace App\DTO;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CarDTO
{
    public function __construct(        
        #[Assert\NotBlank]        
        public readonly string $make,
        #[Assert\NotBlank]
        public readonly string $model,
        #[Assert\NotBlank]
        public readonly int $color,        
        #[Assert\GreaterThanOrEqual('-4 years')]        
        public readonly ?DateTimeInterface $buildDate,
    ) {        
    }
}