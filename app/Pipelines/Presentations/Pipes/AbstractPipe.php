<?php

declare(strict_types=1);


namespace App\Pipelines\Presentations\Pipes;

abstract class AbstractPipe
{
    protected function checkArrayValuesExists($phrases): bool
    {
        $collection = collect($phrases);

        return $collection->contains(function ($value) {
            return isset($value);
        });
    }

    protected function getNewPhrasesData($presentationId, $phrasesArr): array
    {
        foreach ($phrasesArr as $phrase) {
            if (!empty($phrase)) {
                $phrases[] = [
                    'phrase' => $phrase,
                    'presentation_id' => $presentationId,
                ];
            }
        }

        return $phrases ?? $phrasesArr;
    }

    protected function getNewPopupData($presentationId, $popup): array
    {
        $data = [
            'presentation_id' => $presentationId,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        return array_merge($popup, $data);
    }
}
