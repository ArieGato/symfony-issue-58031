<?php

namespace App\Dto;

/**
 * @template T of DtoBase
 */
class Wrapper
{
    /**
     * @var T
     */
    public mixed $dto;
}