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
        return QueryBuilder::for(Record::query()->withoutGlobalScopes([OrderByIdScope::class])->byUser()->with(['user']))
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
        return QueryBuilder::for(Record::with(['values', 'table'])->byUser())
            ->where('TableId', '=', $table->Id)
            ->where('UserId', '=', $user->Id)
            ->where('Status', '=', true)
            ->paginate();
    }

    /**
     * @param Record|null $record
     * @param array $validated
     * @return Record
     * @throws Exception
     */
    public function create(?Record $record = null, array $validated): Record
    {
        DB::beginTransaction();
        try {

            if (is_null($record)) {
                /** @var Record $record */
                $record = Record::query()->create([
                    'UserId' => auth()->id(),
                ]);
            }
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
     * @param Table $table
     * @param array $validated
     * @return Record
     * @throws Exception
     */
    public function uploadFile(Table $table, array $validated): Record
    {
        DB::beginTransaction();
        try {
            $record = $this->getRecord($table, $validated);
            /** @var UploadedFile $file */
            $file = $validated['file'];
            $file_name = "file_r_{$record->Id}_u_"
                . auth()->id()
                . "_f_{$validated['FieldId']}.{$file->getClientOriginalExtension()}";
            $file->storeAs('files', $file_name);
            Value::query()->updateOrCreate([
                'RecordId' => $record->Id,
                'FieldId' => $validated['FieldId'],
            ], [
                'File' => $file_name,
                'Value' => $file->getClientOriginalName(),
            ]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $record->load('values');

    }

    /**
     * @param Record $record
     * @param array $validated
     * @return Record
     * @throws Exception
     */
    public function uploadUpdate(Record $record, array $validated): Record
    {
        DB::beginTransaction();
        try {
            $fileValue = $record
                ->values()
                ->where('FieldId', '=', $validated['FieldId'])
                ->first();
            Storage::delete("files/{$fileValue->File}");
            /** @var UploadedFile $file */
            $file = $validated['file'];
            $file_name = 'file_' . date('Y-m-d_H-i-s') . ".{$file->getClientOriginalExtension()}";
            $file->storeAs('files', $file_name);
            $fileValue->File = $file_name;
            $fileValue->Value = $file->getClientOriginalName();
            $fileValue->save();
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
     * @param Table $table
     * @param array $validated
     * @return Record
     */
    protected function getRecord(Table $table, array $validated): Record
    {
        /** @var Record $record */
        $record = Record::query()
            ->withoutGlobalScopes()
            ->firstOrCreate([
                'UserId' => auth()->id(),
                'TableId' => $table->Id,
                'Status' => false,
            ])->load('values');
        if ($file = $record->values()->where('FieldId', '=', $validated['FieldId'])->first()) {
            Storage::delete("files/{$file->File}");
        }
        return $record;
    }
}
