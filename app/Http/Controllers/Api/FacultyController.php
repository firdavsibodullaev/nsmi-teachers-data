<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FacultyRequest;
use App\Http\Resources\FacultyResource;
use App\Models\Faculty;
use App\Services\FacultyService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * Class FacultyController
 * @package App\Http\Controllers\Api
 */
class FacultyController extends Controller
{

    /**
     * @var FacultyService
     */
    private $facultyService;

    /**
     * FacultyController constructor.
     * @param FacultyService $facultyService
     */
    public function __construct(FacultyService $facultyService)
    {
        $this->facultyService = $facultyService;
    }

    /**
     * Index
     *
     * Метод возвращает список факультетов
     * Display a listing of the resource.
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $faculties = $this->facultyService->fetchAllWithPagination();
        return FacultyResource::collection($faculties);
    }

    /**
     * Store
     *
     * Создать новый факультет
     *
     * @param FacultyRequest $request
     * @return FacultyResource
     */
    public function store(FacultyRequest $request): FacultyResource
    {
        $faculty = $this->facultyService->create($request->validated());
        return new FacultyResource($faculty);
    }

    /**
     * Выбрать определенный факультет
     *
     * @param Faculty $faculty
     * @return FacultyResource
     */
    public function show(Faculty $faculty): FacultyResource
    {
        return new FacultyResource($faculty->load('departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FacultyRequest $request
     * @param Faculty $faculty
     * @return FacultyResource
     */
    public function update(FacultyRequest $request, Faculty $faculty): FacultyResource
    {
        $faculty = $this->facultyService->update($faculty, $request->validated());
        return new FacultyResource($faculty);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Faculty $faculty
     * @return false|Application|ResponseFactory|Response
     * @throws Exception
     */
    public function destroy(Faculty $faculty)
    {
        if ($this->facultyService->delete($faculty)) {
            return response('', 204);
        }
        return false;
    }
}
