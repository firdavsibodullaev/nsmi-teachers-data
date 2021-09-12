<?php

namespace App\Services;

use App\Interfaces\UserInterface;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class UserService
 * @package App\Services
 */
class UserService implements UserInterface
{

    /**
     * Выборка пользователя с возможностью фильтрации и пагинацией
     * @return LengthAwarePaginator
     */
    public function fetchAllWithPagination(): LengthAwarePaginator
    {
        return QueryBuilder::for(User::class)
            ->allowedFilters(['FirstName', 'LastName', 'Patronymic'])
            ->with(['faculty', 'department'])
            ->paginate(15);
    }

    /**
     * Создаст нового пользователя
     * @param array $validated
     * @return Builder|Model
     */
    public function create(array $validated)
    {
        return User::query()->create($validated)->load(['faculty', 'department']);
    }

    /**
     * Изменяет пользователя
     * @param User $user
     * @param array $validated
     * @return mixed
     */
    public function update(User $user, array $validated)
    {
        return tap($user)->update($validated)->load(['faculty', 'department']);
    }

    /**
     * Удаляет пользователя
     *
     * @param User $user
     * @return bool|null
     * @throws Exception
     */
    public function delete(User $user): ?bool
    {
        return $user->delete();
    }
}
