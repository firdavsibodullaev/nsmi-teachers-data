<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends BaseModel
{
    use SoftDeletes;

    /**
     * @return HasOne
     */
    public function faculty(): HasOne
    {
        return $this->hasOne(Faculty::class, 'Id', 'FacultyId');
    }
}
