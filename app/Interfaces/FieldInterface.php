<?php


namespace App\Interfaces;

use App\Models\Field;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface FieldInterface
{
    /**
     * Возвращает список полей с возможностью фильтрации и пагинацией
     * @return LengthAwarePaginator
     */
    public function fetchAllWithPagination(): LengthAwarePaginator;

    /**
     * Создаёт поле для таблицы
     * @param array $validated
     * @return Builder|Model
     */
    public function create(array $validated);

    /**
     * Изменяет поле таблицы
     * @param Field $field
     * @param array $validated
     * @return mixed
     */
    public function update(Field $field, array $validated);

    /**
     * Удаляет поле таблицы
     * @param Field $field
     * @return bool|null
     * @throws Exception
     */
    public function delete(Field $field): ?bool;
}
