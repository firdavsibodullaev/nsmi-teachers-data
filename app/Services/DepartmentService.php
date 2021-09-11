<?php

namespace App\Services;

use App\Interfaces\DepartmentInterface;
use App\Models\Department;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class DepartmentService
 * @package App\Services
 */
class DepartmentService implements DepartmentInterface
{
    /**
     * Список всех кафедр с возможностью фильтрации и пагинацией
     * @return LengthAwarePaginator
     */
    public function fetchAllWithPagination(): LengthAwarePaginator
    {
        return QueryBuilder::for(Department::class)
            ->allowedFilters([
                'FullNameUz',
                'FullNameRu',
                'FullNameOz',
                'ShortNameUz',
                'ShortNameOz',
                'ShortNameRu',
            ])
            ->with('faculty')
            ->paginate(15);
    }

    /**
     * Создание новой кафедры
     *
     * @param array $validated
     * @return Builder|Model
     */
    public function create(array $validated)
    {
        return Department::query()->create($validated)->load('Faculty');
    }

    /**
     * Обновление кафедры
     *
     * @param Department $department
     * @param array $validated
     * @return mixed
     */
    public function update(Department $department, array $validated)
    {
        return tap($department)->update($validated)->load('faculty');
    }

    /**
     * Удаление кафедры
     *
     * @param Department $department
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Department $department): ?bool
    {
        return $department->delete();
    }
}
