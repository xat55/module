<?php


declare(strict_types=1);

namespace App\Repositories\V2\Presentation;

use App\Models\Presentation;
use App\Dto\Entities\PresentationDto;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use App\Services\QueryBuilders\PresentationQueryBuilder;
use Illuminate\Database\Eloquent\Model;

final class EloquentPresentationRepository implements PresentationRepositoryInterface
{
    public function __construct(private Presentation $model, private PresentationQueryBuilder $builder)
    {
    }

    public function getAllByFilters(): Collection|array
    {
        return $this->builder->getAllByFilters($this->model);
    }

    public function getShowDetailByFilters(): Model|QueryBuilder
    {
        return $this->builder->getShowDetailByFilters($this->model);
    }

    public function store(PresentationDto $dto): PresentationDto
    {
        $object = $this->model
            ->newQuery()
            ->create($dto->toArray());

        return PresentationDto::fromArray($object->toArray());
    }

    public function update(array $condition, array $data): void
    {
        $this->model
            ->newQuery()
            ->where($condition)
            ->update($data);
    }

    public function delete(array $filters): void
    {
        $this->model
            ->newQuery()
            ->where($filters)
            ->delete();
    }
}

