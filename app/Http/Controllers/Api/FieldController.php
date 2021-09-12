<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FieldRequest;
use App\Http\Resources\FieldResource;
use App\Models\Field;
use App\Services\FieldService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class FieldController extends Controller
{

    /**
     * @var FieldService
     */
    private $fieldService;

    public function __construct(FieldService $fieldService)
    {
        $this->fieldService = $fieldService;
    }

    /**
     * Index
     *
     * Метод возвращает список полей с возможностью фильтрации и пагинацией
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $fields = $this->fieldService->fetchAllWithPagination();
        return FieldResource::collection($fields);
    }

    /**
     * Store
     *
     * Метод создаёт новое поле
     *
     * @param FieldRequest $request
     * @return FieldResource
     */
    public function store(FieldRequest $request): FieldResource
    {
        $field = $this->fieldService->create($request->validated());
        return new FieldResource($field);
    }

    /**
     * Show
     *
     * Метод выбирает определенное поле
     *
     * @param Field $field
     * @return FieldResource
     */
    public function show(Field $field): FieldResource
    {
        return new FieldResource($field->load('tables'));
    }

    /**
     * Update
     *
     * Метод изменяет определенное поле
     *
     * @param FieldRequest $request
     * @param Field $field
     * @return FieldResource
     */
    public function update(FieldRequest $request, Field $field): FieldResource
    {
        $field = $this->fieldService->update($field, $request->validated());
        return new FieldResource($field);
    }

    /**
     * Delete
     *
     * Метод удаляет определенное поле
     *
     * @param Field $field
     * @return false|Application|ResponseFactory|Response
     * @throws Exception
     */
    public function destroy(Field $field)
    {
        if ($this->fieldService->delete($field)) {
            return response('', 204);
        }
        return false;
    }
}
