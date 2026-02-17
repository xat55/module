<?php


declare(strict_types=1);

namespace App\Services\V2\Presentation;

use App\Dto\Entities\PresentationDto;
use App\Repositories\V2\Presentation\PresentationRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

final class PresentationService implements PresentationServiceInterface
{
    public function __construct(private PresentationRepositoryInterface $repository)
    {
    }

    public function list(): array|Collection
    {
        return $this->repository->getAllByFilters();
    }

    public function detail(): Model|QueryBuilder
    {
        return $this->repository->getShowDetailByFilters();
    }

    public function store(PresentationDto $dto): PresentationDto
    {
        return $this->repository->store($dto);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update($condition, array_filter($data));
    }

    public function delete(array $filters): void
    {
        $this->repository->delete(array_filter($filters));
    }
}
