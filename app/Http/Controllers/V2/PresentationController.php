<?php


declare(strict_types=1);

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Presentation\ListRequest;
use App\Http\Requests\Presentation\DetailRequest;
use App\Http\Requests\Presentation\StoreRequest;
use App\Http\Requests\Presentation\UpdateRequest;
use App\Http\Requests\Presentation\DestroyRequest;
use App\Http\Resources\PresentationResource;
use App\Http\Resources\PresentationCollection;
use App\Pipelines\Presentations\PresentationPipeline;
use App\Services\V2\Presentation\PresentationServiceInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class PresentationController extends Controller
{
    public function __construct(
        private PresentationServiceInterface $presentationService,
        private PresentationPipeline $pipeline
    ){}

    public function list(ListRequest $request): JsonResponse
    {
        $request->validated();

        $query = $this->presentationService->list();

        $collection = new PresentationCollection($query);

        return response()->json($collection);
    }

    public function detail(DetailRequest $request): JsonResponse
    {
        $request->validated();

        $query = $this->presentationService->detail();

        $resource = new PresentationResource($query);

        return response()->json([
            'data' => $resource
        ]);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        /** @var PresentationPipelineDto $dto */
        [$dto, $e] = $this->pipeline->store($request->dto());

        if (!$e) {
            return response()->json([
                'data' => $dto->getPresentation()->toArray()
            ], Response::HTTP_CREATED);
        }

        return response()->__call('pipeline_exception', [$e]);
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        [$dto, $e] = $this->pipeline->update($request->dto());

        if (!$e) {
            return response()->json();
        }

        return response()->__call('pipeline_exception', [$e]);
    }

    public function destroy(DestroyRequest $request): JsonResponse
    {
        [$dto, $e] = $this->pipeline->delete($request->dto());

        if (!$e) {
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }

        return response()->__call('pipeline_exception', [$e]);
    }

}
