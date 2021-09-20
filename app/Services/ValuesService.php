<?php

namespace App\Services;

use App\Interfaces\ValuesInterface;
use App\Models\Record;
use App\Models\Table;
use App\Models\User;
use App\Models\Value;
use App\Scopes\OrderByIdScope;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class ValuesService
 * @package App\Services
 */
class ValuesService implements ValuesInterface
{
    //
    /**
     * @param Table $table
     * @return LengthAwarePaginator
     */
    public function fetchAllWithPagination(Table $table): LengthAwarePaginator
    {
        return QueryBuilder::for(Record::withoutGlobalScopes([OrderByIdScope::class])->with(['user']))
            ->select([DB::raw('count(*) as total'), "UserId"])
            ->allowedSorts(['UserId'])
            ->where('TableId', '=', $table->Id)
            ->groupBy('UserId')
            ->paginate();
    }

    /**
     * @param Table $table
     * @param User $user
     * @return LengthAwarePaginator
     */
    public function list(Table $table, User $user): LengthAwarePaginator
    {
        return QueryBuilder::for(Record::with(['values', 'table']))
            ->where('TableId', '=', $table->Id)
            ->where('UserId', '=', $user->Id)
            ->paginate();
    }

    /**
     * @throws Exception
     */
    public function create(array $validated): Record
    {
        DB::beginTransaction();
        try {
            /** @var Record $record */
            $record = Record::query()->create([
                'UserId' => auth()->id(),
                'TableId' => $validated['TableId']
            ]);
            $valuesArray = [];
            foreach ($validated['Values'] as $value) {
                $value['File'] = $this->file($value);
                $value['RecordId'] = $record->Id;
                array_push($valuesArray, $value);
            }
            Value::query()->insert($valuesArray);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $record->load(['values', 'user', 'table']);
    }

    /**
     * @throws Exception
     */
    public function update(Record $record, array $validated)
    {
        DB::beginTransaction();
        try {
            foreach ($validated['Values'] as $value) {

                $updateArray = [
                    'Value' => $value['Value'],
                ];

                if ($fileName = $this->updateFile($record, $value)) {
                    $updateArray['File'] = $fileName;
                }

                Value::query()
                    ->where('RecordId', '=', $record->Id)
                    ->where('FieldId', '=', $value['FieldId'])
                    ->update($updateArray);
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $record->load(['user', 'values', 'table']);
    }

    public function delete(Record $record): ?bool
    {
        $record->values()->delete();
        return $record->delete();
    }

    /**
     * @param array $value
     * @return string|null
     */
    private function file(array $value): ?string
    {
        if (!isset($value['File'])) {
            return null;
        }

        /** @var UploadedFile $file */
        $file = $value['File'];

        $file_name = 'file_' . date('Y-m-d_H-i-s') . '_' . $file->getClientOriginalName();
        $file->storeAs('files', $file_name);
        return $file_name;
    }

    /**
     * @param Record $record
     * @param array $value
     * @return string|null
     */
    protected function updateFile(Record $record, array $value): ?string
    {
        if (!isset($value['File'])) {
            return null;
        }
        $dValue = Value::query()
            ->where('FieldId', $value['FieldId'])
            ->where('RecordId', '=', $record->Id)
            ->first();
        Storage::delete("storage/files/{$dValue->File}");
        return $this->file($value);
    }
}
