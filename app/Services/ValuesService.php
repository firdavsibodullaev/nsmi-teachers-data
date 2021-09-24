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
            ->where('Status', '=', true)
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
            ->where('Status', '=', true)
            ->paginate();
    }

    /**
     * @throws Exception
     */
    public function create(Record $record, array $validated): Record
    {
        DB::beginTransaction();
        try {
            $valuesArray = [];
            foreach ($validated['Values'] as $value) {
                $value['RecordId'] = $record->Id;
                array_push($valuesArray, $value);
            }
            Value::query()->insert($valuesArray);
            $record = tap($record)->update(['Status' => true, 'TableId' => $validated['TableId']]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $record->load(['values', 'user', 'table']);
    }

    /**
     * @param array $validated
     * @return Record
     * @throws Exception
     */
    public function uploadFile(array $validated): Record
    {
        DB::beginTransaction();
        try {

            $this->deleteRecords();
            /** @var Record $record */
            $record = Record::query()->create([
                'UserId' => auth()->id(),
            ]);
            /** @var UploadedFile $file */
            $file = $validated['file'];
            $file_name = 'file_' . date('Y-m-d_H-i-s') . '_' . $file->getClientOriginalName();
            $file->storeAs('files', $file_name);
            Value::query()->create([
                'RecordId' => $record->Id,
                'File' => $file_name,
                'Value' => $file->getClientOriginalName(),
                'FieldId' => $validated['FieldId'],
            ]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $record;

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
        Storage::delete("files/{$dValue->File}");
        return $this->file($value);
    }

    protected function deleteRecords()
    {
        $records = Record::query()
            ->withoutGlobalScopes()
            ->with('values')
            ->where('UserId', '=', auth()->id())
            ->where('Status', '=', false)
            ->get();
        foreach ($records as $record) {
            foreach ($record->values as $value) {
                Storage::delete("files/{$value->File}");
            }
            $record->values()->forceDelete();
            $record->forceDelete();
        }
    }
}
