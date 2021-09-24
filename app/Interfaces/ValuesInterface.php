<?php


namespace App\Interfaces;

use App\Models\Record;
use App\Models\Table;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ValuesInterface
{
    /**
     * @param Table $table
     * @return LengthAwarePaginator
     */
    public function fetchAllWithPagination(Table $table): LengthAwarePaginator;

    /**
     * @param array $validated
     * @return Record
     */
    public function create(Record $record, array $validated): Record;

    /**
     * @param Record $record
     * @param array $validated
     * @return mixed
     */
    public function update(Record $record, array $validated);

    /**
     * @param Record $record
     * @return bool|null
     * @throws Exception
     */
    public function delete(Record $record): ?bool;
}
