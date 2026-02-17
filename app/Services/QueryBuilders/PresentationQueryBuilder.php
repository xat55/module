<?php

declare(strict_types=1);

namespace App\Services\QueryBuilders;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class PresentationQueryBuilder
{
    public function getAllByFilters($presentation): Collection|array
    {
        return QueryBuilder::for($presentation)
            ->allowedFilters([
                AllowedFilter::exact('ids', 'id'),
                AllowedFilter::exact('group'),
                AllowedFilter::scope('phrase', 'search_by_phrase'),
            ])
            ->allowedIncludes([
                'phrases'
            ])
            ->allowedSorts(['id', 'name', 'sort'])
            ->get();
    }

    public function getShowDetailByFilters($presentation): Model|QueryBuilder
    {
        return QueryBuilder::for($presentation)
            ->allowedFilters(['id'])
            ->firstOrFail();
    }
}
