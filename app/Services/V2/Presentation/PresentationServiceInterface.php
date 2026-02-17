<?php


namespace App\Services\V2\Presentation;

use App\Dto\Entities\PresentationDto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

interface PresentationServiceInterface
{
    public function list(): array|Collection;

    public function detail(): Model|QueryBuilder;

    public function store(PresentationDto $dto): PresentationDto;

    public function update(array $condition, array $data): void;

    public function delete(array $filters): void;
}
