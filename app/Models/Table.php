<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends BaseModel
{
    use SoftDeletes;

    /**
     * @return BelongsToMany
     */
    public function fields(): BelongsToMany
    {
        return $this->belongsToMany(Field::class, 'field_tables', 'TableId', 'FieldId');
    }
}
