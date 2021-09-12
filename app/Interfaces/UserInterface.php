<?php

namespace App\Interfaces;

use App\Models\User;

interface UserInterface
{
    public function fetchAllWithPagination();

    public function create(array $validated);

    public function update(User $user, array $validated);

    public function delete(User $user);
}
