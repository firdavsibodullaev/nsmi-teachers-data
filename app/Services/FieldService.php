<?php

namespace App\Services;

use App\Constants\FieldTypeConstants;
use App\Interfaces\FieldInterface;
use App\Models\Field;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class FieldService
 * @package App\Services
 */
class FieldService implements FieldInterface
{
    /**
     * Возвращает список полей с возможностью фильтрации и пагинацией
     * @return LengthAwarePaginator
     */
    public function fetchAllWithPagination(): LengthAwarePaginator
    {
        return QueryBuilder::for(Field::class)
            ->allowedFilters([
                'FullName', 'ShortName'
            ])
            ->with('tables')
            ->paginate(15);
    }

    /**
     * Создаёт поле для таблицы
     * @param array $validated
     * @return Builder|Model
     */
    public function create(array $validated)
    {
        if (!isset($validated['Type'])) {
            $validated['Type'] = FieldTypeConstants::STRING;
        }
        return Field::query()->create($validated)->load('tables');
    }

    /**
     * Изменяет поле таблицы
     * @param Field $field
     * @param array $validated
     * @return mixed
     */
    public function update(Field $field, array $validated)
    {
        return tap($field)->update($validated)->load('tables');
    }

    /**
     * @param Field $field
     * @return bool|null
     * @throws Exception
     */
    public function delete(Field $field): ?bool
    {
        return $field->delete();
    }
}
