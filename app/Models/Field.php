<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends BaseModel
{
    use SoftDeletes;
    /**
     * @return BelongsToMany
     */
    public function table(): BelongsToMany
    {
        return $this->belongsToMany(Table::class, 'field_tables', 'FieldId', 'TableId');
    }
}
