<?php


declare(strict_types=1);

namespace App\Pipelines\Presentations;

use App\Dto\Pipelines\Presentation\PresentationPipelineDto;

use App\Pipelines\Presentations\Pipes\Create\PresentationPipe as CreatePresentationPipe;
use App\Pipelines\Presentations\Pipes\Create\PresentationPopupPipe as CreatePresentationPopupPipe;
use App\Pipelines\Presentations\Pipes\Create\PresentationPhrasesPipe as CreatePresentationPhrasesPipe;

use App\Pipelines\Presentations\Pipes\Update\PresentationPipe as UpdatePresentationPipe;
use App\Pipelines\Presentations\Pipes\Update\PresentationPopupPipe as UpdatePresentationPopupPipe;
use App\Pipelines\Presentations\Pipes\Update\PresentationPhrasesPipe as UpdatePresentationPhrasesPipe;

use App\Pipelines\Presentations\Pipes\Delete\PresentationPipe as DeletePresentationPipe;

final class PresentationPipeline extends AbstractPipeline
{
    public function store(PresentationPipelineDto $dto): array
    {
        return $this->pipeline([
            CreatePresentationPipe::class,
            CreatePresentationPopupPipe::class,
            CreatePresentationPhrasesPipe::class,
        ], $dto);
    }

    public function update(PresentationPipelineDto $dto): array
    {
        return $this->pipeline([
            UpdatePresentationPipe::class,
            UpdatePresentationPopupPipe::class,
            UpdatePresentationPhrasesPipe::class,
        ], $dto);
    }

    public function delete(PresentationPipelineDto $dto): array
    {
        return $this->pipeline([
            DeletePresentationPipe::class,
        ], $dto);
    }

}
