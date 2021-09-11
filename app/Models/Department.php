<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

class Department extends BaseModel
{
    /**
     * @return HasOne
     */
    public function faculty(): HasOne
    {
        return $this->hasOne(Faculty::class, 'Id', 'FacultyId');
    }
}
