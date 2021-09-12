<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TableRequest;
use App\Http\Resources\TableResource;
use App\Models\Table;
use App\Services\TableService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TableController extends Controller
{
    /**
     * @var TableService
     */
    private $tableService;

    /**
     * TableController constructor.
     * @param TableService $tableService
     */
    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }

    /**
     * Index
     *
     * Метод возвращает список таблиц с пагинацией и фильтрацией
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $tables = $this->tableService->fetchAllWithPagination();
        return TableResource::collection($tables);
    }

    /**
     * Show
     *
     * Выборка определенной таблицы
     * @param Table $table
     * @return TableResource
     */
    public function show(Table $table): TableResource
    {
        return new TableResource($table->load('fields'));
    }

    /**
     * Store
     *
     * Создаёт новую таблицу
     * @param TableRequest $request
     * @return TableResource
     */
    public function store(TableRequest $request): TableResource
    {
        $table = $this->tableService->create($request->validated());
        return new TableResource($table);
    }

    /**
     * Update
     * Метод изменяет таблицу
     * @param TableRequest $request
     * @param Table $table
     * @return TableResource
     */
    public function update(TableRequest $request, Table $table): TableResource
    {
        $table = $this->tableService->update($table, $request->validated());
        return new TableResource($table);
    }

    /**
     * Destroy
     *
     * Метод удаляет таблицу
     * @param Table $table
     * @return false|Application|ResponseFactory|Response
     * @throws Exception
     */
    public function destroy(Table $table)
    {
        $table = $this->tableService->delete($table);
        if ($table) {
            return response('', 204);
        }
        return false;
    }
}
