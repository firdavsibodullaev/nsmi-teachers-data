<?php


namespace App\Interfaces;

use App\Models\Table as TableModel;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface Table
{
    /**
     * @return LengthAwarePaginator
     */
    public function fetchAllWithPagination(): LengthAwarePaginator;

    /**
     * @param array $validated
     * @return TableModel
     */
    public function create(array $validated): TableModel;

    /**
     * @param TableModel $table
     * @param array $validated
     * @return mixed
     */
    public function update(TableModel $table, array $validated);

    /**
     * @param TableModel $table
     * @return bool|null
     * @throws Exception
     */
    public function delete(TableModel $table): ?bool;

}
