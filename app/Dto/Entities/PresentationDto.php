<?php


declare(strict_types=1);


namespace App\Dto\Entities;

use App\Dto\Contracts\DtoInterface;

class PresentationDto implements DtoInterface
{
    private $id;
    private $published;
    private $title;
    private $description;
    private $link;
    private $h5;
    private $group;
    private $color;
    private $sort;
    private $recomm_bp;
    private $phrases;
    private $popup;
    private $deleted_at;
    private $created_at;
    private $updated_at;

    public function __construct(
        ?int    $id,
        ?bool   $published,
        ?string $title,
        ?string $description,
        ?string $link,
        ?string $h5,
        ?string $group,
        ?string $color,
        ?string    $sort,
        ?string $recomm_bp,
        ?array  $phrases,
        ?array  $popup,
        ?string $deletedAt,
        ?string $createdAt,
        ?string $updatedAt
    )
    {
        $this->id          = $id;
        $this->published   = $published;
        $this->title       = $title;
        $this->description = $description;
        $this->link        = $link;
        $this->h5          = $h5;
        $this->group       = $group;
        $this->color       = $color;
        $this->sort        = $sort;
        $this->recomm_bp   = $recomm_bp;
        $this->phrases     = $phrases;
        $this->popup       = $popup;
        $this->deleted_at  = $deletedAt;
        $this->created_at  = $createdAt;
        $this->updated_at  = $updatedAt;
    }

    public static function fromArray(array $arguments): self
    {
        return new self(
            $arguments['id'] ?? null,
            $arguments['published'] ?? null,
            $arguments['title'] ?? null,
            $arguments['description'] ?? null,
            $arguments['link'] ?? null,
            $arguments['h5'] ?? null,
            $arguments['group'] ?? null,
            $arguments['color'] ?? null,
            $arguments['sort'] ?? null,
            $arguments['recomm_bp'] ?? null,
            $arguments['phrases'] ?? [],
            $arguments['popup'] ?? [],
            $arguments['deleted_at'] ?? null,
            $arguments['created_at'] ?? null,
            $arguments['updated_at'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'published'   => $this->published,
            'title'       => $this->title,
            'description' => $this->description,
            'link'        => $this->link,
            'h5'          => $this->h5,
            'group'       => $this->group,
            'color'       => $this->color,
            'sort'        => $this->sort,
            'recomm_bp'   => $this->recomm_bp,
            'phrases'     => $this->phrases,
            'popup'       => $this->popup,
            'deleted_at'  => $this->deleted_at,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published = true): void
    {
        $this->published = $published;
    }

    public function setPopup($popup): void
    {
        $this->popup = $popup;
    }

    public function setPhrases($phrases): void
    {
        $this->phrases = $phrases;
    }
}
