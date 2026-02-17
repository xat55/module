<?php


namespace App\Pipelines\Presentations\Pipes\Update;

use App\Dto\Contracts\DtoInterface;
use App\Services\V2\Presentation\PresentationService;
use App\Dto\Contracts\PipeInterface;
use Closure;

class PresentationPipe implements PipeInterface
{
    public function __construct(private PresentationService $service)
    {
    }

    public function handle(DtoInterface|PresentationPipelineDto $dto, Closure $next): DtoInterface
    {
        $presentation = $dto->getPresentation();
        $id = $presentation->getId();

        $this->service->update([
            ['id', $id],
        ], $presentation->toArray());

        return $next($dto);
    }
}
