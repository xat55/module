<?php


declare(strict_types=1);


namespace App\Dto\Pipelines\Presentation;

use App\Dto\Contracts\DtoInterface;
use App\Dto\Entities\PresentationDto;
use Illuminate\Database\Eloquent\Model;

class PresentationPipelineDto implements DtoInterface
{
    public function __construct(private PresentationDto $presentation, private $popup = [], private $phrases = []){}

    public function toArray(): array
    {
        return [
            'presentation' => $this->presentation,
            'popup' => $this->popup,
            'phrases' => $this->phrases,
        ];
    }

    public static function fromArray(array $arguments): self
    {
        return new self($arguments['presentation']);
    }

    public function getPresentation(): PresentationDto
    {
        return $this->presentation;
    }

    public function setPresentation(PresentationDto $dto): void
    {
        $this->presentation = $dto;
    }

    public function getPopup(): array|Model
    {
        return $this->popup;
    }

    public function setPopupIntoPresentation($dto): void
    {
        $this->presentation->setPopup($dto->toArray());
    }
    public function getPhrases(): ?array
    {
        return $this->phrases;
    }
    public function setPhrasesIntoPresentation($dto): void
    {
        $this->presentation->setPhrases($dto->toArray());
    }
}
