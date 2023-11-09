<?php

namespace App\DTO;

class ColorDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $name
    ) {        
    }
}