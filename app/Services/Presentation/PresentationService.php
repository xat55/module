<?php


declare(strict_types=1);

namespace App\Services\Presentation;

use App\Http\Requests\Presentation\DetailRequest;
use App\Http\Requests\Presentation\ListRequest;
use App\Http\Requests\Presentation\StoreRequest;
use App\Http\Requests\Presentation\UpdateRequest;
use App\Http\Resources\PresentationCollection;
use App\Http\Resources\PresentationResource;
use App\Models\Popup;
use App\Models\Presentation;
use App\Models\SearchPhrase;
use App\Repositories\V1\Presentation\PresentationRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

final class PresentationService implements PresentationServiceInterface
{
    private PresentationRepository $presentationRepository;

    public function __construct(PresentationRepository $presentationRepository)
    {
        $this->presentationRepository = $presentationRepository;
    }

    public function list(ListRequest $request): Collection|PresentationCollection
    {
        $query = $this->presentationRepository->getPresentationsByFilters($request);

        return new PresentationCollection($query);
    }

    public function detail(DetailRequest $request): PresentationResource
    {
        return $this->presentationRepository->getPresentationDetailByFilters($request);
    }

    public function store(StoreRequest $request): Presentation
    {
        $data = $request->validated();

        $data = $this->addSortParameterIfMissing($request, $data);

        if ($request->hasFile(Presentation::FIELD_LINK)) {
            $data[Presentation::FIELD_LINK] = Storage::put('uploads/directions', $request->file(Presentation::FIELD_LINK));
        }

        return DB::transaction(function () use ($data, $request) {
            $presentation = $this->presentationRepository->store($data);

            if (!empty($phrases = $this->getPhrases($request))) {
                $presentation->phrases()->createMany($phrases);
            }

            if (!empty($popup = $this->getPopup($request))) {
                $presentation->popup()->create($popup);
            }

            return $presentation;
        });
    }

    public function update(UpdateRequest $request): Presentation
    {
        $data = $request->validated();

        $this->getPhrases($request);

        if ($request->hasFile(Presentation::FIELD_LINK)) {
            $data[Presentation::FIELD_LINK] = Storage::put('uploads/directions', $request->file(Presentation::FIELD_LINK));
        }

        return DB::transaction(function () use ($data, $request) {
            $presentation = $this->presentationRepository->update($data);

            $presentation->phrases()->delete();

            if (!empty($phrases = $this->getPhrases($request))) {
                $presentation->phrases()->createMany($phrases);
            }

            if (!empty($popup = $this->getPopup($request))) {
                $presentation->popup()->updateOrCreate([
                    Popup::FIELD_ID => $presentation->popup()->first()->id ?? null
                ], $popup);
            }

            return $presentation;
        });
    }

    public function destroy(int $id): ?bool
    {
        $presentation = Presentation::findOrFail($id);

        return $this->presentationRepository->destroy($presentation);
    }

    private function getPhrases($request): array
    {
        $phrases = [];

        if ($request->filled(Presentation::ENTITY_RELATIVE_PHRASES)) {
            foreach ($request->get(Presentation::ENTITY_RELATIVE_PHRASES) as $phraseData) {
                if (!empty($phraseData)) {
                    $phrases[] = [
                        SearchPhrase::FIELD_PHRASE => $phraseData,
                    ];
                }
            }
        }

        return $phrases;
    }

    private function getPopup($request): array
    {
        $popup = [];

        if ($request->filled(Presentation::ENTITY_RELATIVE_POPUP)) {
            $popup = $request->get(Presentation::ENTITY_RELATIVE_POPUP);
        }

        return $popup;
    }

    private function addSortParameterIfMissing($request, $data)
    {
        if (!$request->has(Presentation::FIELD_SORT)) {
            $sort = Presentation::latest(Presentation::FIELD_SORT)->value(Presentation::FIELD_SORT);
            $data[Presentation::FIELD_SORT] = $sort + 100;
        }

        return $data;
    }

}

