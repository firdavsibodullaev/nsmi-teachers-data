<?php

namespace App\Interfaces;

use App\Models\Department;

interface DepartmentInterface
{
    public function fetchAllWithPagination();

    public function create(array $validated);

    public function update(Department $department, array $validated);

    public function delete(Department $department);
}
