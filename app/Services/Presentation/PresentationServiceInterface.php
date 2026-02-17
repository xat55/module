<?php


namespace App\Services\Presentation;

use App\Http\Requests\Presentation\DetailRequest;
use App\Http\Requests\Presentation\ListRequest;
use App\Http\Requests\Presentation\StoreRequest;
use App\Http\Requests\Presentation\UpdateRequest;
use App\Http\Resources\PresentationCollection;
use App\Http\Resources\PresentationResource;
use App\Models\Presentation;
use Illuminate\Support\Collection;

interface PresentationServiceInterface
{
    public function list(ListRequest $request): Collection|PresentationCollection;

    public function detail(DetailRequest $request): PresentationResource;

    public function store(StoreRequest $request): Presentation;

    public function update(UpdateRequest $request): Presentation;

    public function destroy(int $id): ?bool;
}
