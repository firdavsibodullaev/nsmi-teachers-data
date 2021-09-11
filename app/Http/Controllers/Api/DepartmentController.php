<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Services\DepartmentService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * Class DepartmentController
 * @package App\Http\Controllers\Api
 */
class DepartmentController extends Controller
{

    /**
     * @var DepartmentService
     */
    private $departmentService;

    /**
     * DepartmentController constructor.
     * @param DepartmentService $departmentService
     */
    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    /**
     * Index
     *
     * Список всех кафедр с возможностью филтра и пагинацией
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $departments = $this->departmentService->fetchAllWithPagination();
        return DepartmentResource::collection($departments);
    }

    /**
     * Store
     *
     * Создание новых кафедр
     *
     * @param DepartmentRequest $request
     * @return DepartmentResource
     */
    public function store(DepartmentRequest $request): DepartmentResource
    {
        $department = $this->departmentService->create($request->validated());
        return new DepartmentResource($department);
    }

    /**
     * Show
     *
     * Выборка определенной кафедры
     *
     * @param Department $department
     * @return DepartmentResource
     */
    public function show(Department $department): DepartmentResource
    {
        return new DepartmentResource($department->load('faculty'));
    }

    /**
     * Update
     *
     * Изменение кафедры
     *
     * @param DepartmentRequest $request
     * @param Department $department
     * @return DepartmentResource
     */
    public function update(DepartmentRequest $request, Department $department): DepartmentResource
    {
        $department = $this->departmentService->update($department, $request->validated());
        return new DepartmentResource($department);
    }

    /**
     * Delete
     *
     * Удаление определенной кафедры
     *
     * @param Department $department
     * @return false|Application|ResponseFactory|Response
     * @throws Exception
     */
    public function destroy(Department $department)
    {
        if ($this->departmentService->delete($department))
            return response('', 204);
        return false;
    }
}
