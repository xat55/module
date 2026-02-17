<?php


namespace App\Dto\Contracts;

use Closure;

interface PipeInterface
{
    public function handle(DtoInterface $dto, Closure $next): DtoInterface;
}
