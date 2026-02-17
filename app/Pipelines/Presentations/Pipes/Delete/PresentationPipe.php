<?php


namespace App\Pipelines\Presentations\Pipes\Delete;

use App\Dto\Contracts\DtoInterface;
use App\Dto\Contracts\PipeInterface;
use App\Services\V2\Presentation\PresentationService;
use Closure;

class PresentationPipe implements PipeInterface
{
    public function __construct(private PresentationService $service)
    {}

    public function handle(DtoInterface $dto, Closure $next): DtoInterface
    {
        $presentation = $dto->getPresentation();
        $id = $presentation->getId();

        $this->service->delete([
            ['id', $id],
        ]);

        return $next($dto);
    }
}
