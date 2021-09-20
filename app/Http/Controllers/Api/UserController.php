<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{

    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Index
     *
     * Список всех пользователей
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $users = $this->userService->fetchAllWithPagination();

        return UserResource::collection($users);
    }

    /**
     * Store
     *
     * Создание нового пользователя
     *
     * @param UserRequest $request
     * @return UserResource
     */
    public function store(UserRequest $request): UserResource
    {
        $user = $this->userService->create($request->validated());

        return new UserResource($user);
    }

    /**
     * Show
     *
     * Выборка определенного пользователя
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user->load(['faculty', 'department']));
    }

    /**
     * Update
     *
     * Изменение определенного пользователя
     *
     * @param UserRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(UserRequest $request, User $user): UserResource
    {
        $user = $this->userService->update($user, $request->validated());
        return new UserResource($user);
    }

    /**
     * Delete
     *
     * Удаление определенного пользователя
     *
     * @param User $user
     * @return false|Application|ResponseFactory|Response
     * @throws Exception
     */
    public function destroy(User $user)
    {
        if ($this->userService->delete($user))
            return response('', 204);
        return false;
    }
}
