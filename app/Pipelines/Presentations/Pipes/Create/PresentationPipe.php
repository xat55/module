<?php


declare(strict_types=1);


namespace App\Pipelines\Presentations\Pipes\Create;

use App\Dto\Contracts\DtoInterface;
use App\Dto\Contracts\PipeInterface;
use App\Services\V2\Presentation\PresentationService;
use App\Dto\Pipelines\Presentation\PresentationPipelineDto;
use Closure;

class PresentationPipe implements PipeInterface
{
    public function __construct(private PresentationService $service)
    {
    }

    public function handle(DtoInterface|PresentationPipelineDto $dto, Closure $next): DtoInterface
    {
        $presentation = $dto->getPresentation();

        $this->setPublished($presentation);

        $res = $this->service->store($presentation);

        $dto->setPresentation($res);

        return $next($dto);
    }

    /**
     * @param $presentation
     *
     * @return void
     */
    public function setPublished($presentation): void
    {
        if (is_null($presentation->getPublished())) {
            $presentation->setPublished();
        }
    }
}
