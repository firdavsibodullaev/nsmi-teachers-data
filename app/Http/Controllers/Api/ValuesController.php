<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValueRequest;
use App\Http\Resources\RecordGroupResource;
use App\Http\Resources\RecordResource;
use App\Models\Record;
use App\Models\Table;
use App\Services\ValuesService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * Class ValuesController
 * @package App\Http\Controllers\Api
 */
class ValuesController extends Controller
{
    /**
     * @var ValuesService
     */
    private $valuesService;

    /**
     * ValuesController constructor.
     * @param ValuesService $valuesService
     */
    public function __construct(ValuesService $valuesService)
    {
        $this->valuesService = $valuesService;
    }

    /**
     * @param Table $table
     * @return AnonymousResourceCollection
     */
    public function index(Table $table): AnonymousResourceCollection
    {
        $records = $this->valuesService->fetchAllWithPagination($table);
        return RecordGroupResource::collection($records);
    }

    /**
     * @param Record $record
     * @return RecordResource
     */
    public function show(Record $record): RecordResource
    {
        return new RecordResource($record->load(['user', 'table', 'values']));
    }

    /**
     * @param ValueRequest $request
     * @return RecordResource
     * @throws Exception
     */
    public function store(ValueRequest $request): RecordResource
    {
        $record = $this->valuesService->create($request->validated());

        return new RecordResource($record);
    }

    /**
     * @param ValueRequest $request
     * @param Record $record
     * @return RecordResource
     * @throws Exception
     */
    public function update(ValueRequest $request, Record $record): RecordResource
    {
        $record = $this->valuesService->update($record, $request->validated());

        return new RecordResource($record);
    }

    /**
     * @param Record $record
     * @return false|Application|ResponseFactory|Response
     * @throws Exception
     */
    public function destroy(Record $record)
    {
        if ($this->valuesService->delete($record))
            return response('', 204);

        return false;
    }
}
