<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends BaseModel
{

    /**
     * @return HasMany
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'FacultyId', 'Id');
    }
}
