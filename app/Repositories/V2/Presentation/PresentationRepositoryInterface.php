<?php


declare(strict_types=1);

namespace App\Repositories\V2\Presentation;

use App\Dto\Entities\PresentationDto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

interface PresentationRepositoryInterface
{
    public function getAllByFilters(): Collection|array;

    public function getShowDetailByFilters(): Model|QueryBuilder;

    public function store(PresentationDto $dto): PresentationDto;

    public function update(array $condition, array $data): void;

    public function delete(array $filters): void;
}
