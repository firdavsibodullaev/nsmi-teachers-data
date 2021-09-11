<?php

namespace App\Services;

use App\Models\Faculty;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;
use App\Interfaces\FacultyInterface;

/**
 * Class FacultyService
 * @package App\Services
 */
class FacultyService implements FacultyInterface
{
    /**
     * Список факультетов с фильтрацией по названиям и пагинацией
     * @return LengthAwarePaginator
     */
    public function fetchAllWithPagination(): LengthAwarePaginator
    {
        return QueryBuilder::for(Faculty::class)
            ->allowedFilters([
                'FullNameUz',
                'FullNameRu',
                'FullNameOz',
                'ShortNameUz',
                'ShortNameOz',
                'ShortNameRu',
            ])
            ->with('departments')
            ->paginate(10);
    }

    /**
     * Создание нового факультета
     *
     * @param array $validated
     * @return Builder|Model
     */
    public function create(array $validated)
    {
        return Faculty::query()->create($validated);
    }

    /**
     * Изменение факультета
     *
     * @param Faculty $faculty
     * @param array $validated
     * @return mixed
     */
    public function update(Faculty $faculty, array $validated)
    {
        return tap($faculty)->update($validated);
    }

    /**
     * Удаление факультета
     *
     * @throws Exception
     */
    public function delete(Faculty $faculty): ?bool
    {
        return $faculty->delete();
    }
}
