<?php

namespace App\Services;

use App\Interfaces\Table;
use App\Models\Table as TableModel;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class TableService
 * @package App\Services
 */
class TableService implements Table
{
    /**
     * Возвращает список таблиц с возможностью фильтрации и пагинацией
     *
     * @return LengthAwarePaginator
     */
    public function fetchAllWithPagination(): LengthAwarePaginator
    {
        return QueryBuilder::for(TableModel::class)
            ->allowedFilters([
                'FullName', 'ShortName'
            ])
            ->with('fields')
            ->paginate(10);
    }

    /**
     * Создает новую таблицу
     *
     * @param array $validated
     * @return Builder|Model
     */
    public function create(array $validated)
    {
        return TableModel::query()->create($validated)->load('fields');
    }

    /**
     * Изменяет таблицу
     *
     * @param TableModel $table
     * @param array $validated
     * @return mixed
     */
    public function update(TableModel $table, array $validated)
    {
        return tap($table)->update($validated)->load('fields');
    }

    /**
     * Удаляет таблицу
     *
     * @param TableModel $table
     * @return bool|null
     * @throws Exception
     */
    public function delete(TableModel $table): ?bool
    {
        return $table->delete();
    }
}
