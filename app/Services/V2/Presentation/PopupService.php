<?php

declare(strict_types=1);

namespace App\Services\V2\Presentation;

use App\Repositories\V2\Presentation\PopupRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PopupService
{
    public function __construct(private PopupRepositoryInterface $repository)
    {
    }

    public function create(array $data): Builder|Model
    {
        return $this->repository->create($data);
    }

    public function update(array $condition, array $data): void
    {
        $this->repository->update($condition, $data);
    }

    public function delete(array $filters): void
    {
        $this->repository->delete($filters);
    }

}
