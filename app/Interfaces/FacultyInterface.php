<?php
namespace App\Interfaces;

use App\Models\Faculty;

interface FacultyInterface
{
    public function fetchAllWithPagination();
    public function create(array $validated);
    public function update(Faculty $faculty, array $validated);
    public function delete(Faculty $faculty);
}
