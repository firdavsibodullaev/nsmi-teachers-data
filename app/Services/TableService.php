<?php

namespace App\Services;

use App\Interfaces\Table;
use App\Models\Table as TableModel;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
     * @return TableModel
     */
    public function create(array $validated): TableModel
    {
        /** @var TableModel $table */
        $table = TableModel::query()->create($validated);
        $this->addOrder($validated);
        $table->fields()->sync($validated['Fields']);
        return $table->load('fields');
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
        $table = tap($table)->update($validated);
        $table->fields()->sync($validated['Fields']);
        return $table->load('fields');
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

    protected function addOrder(array &$validated)
    {
        foreach ($validated as $key => $value) {
            $value['order'] = ($key + 1);
        }
    }
}
