<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\HasOne;

class Value extends BaseModel
{
    /**
     * @return HasOne
     */
    public function record(): HasOne
    {
        return $this->hasOne(Record::class, 'Id', 'RecordId');
    }

    /**
     * @return HasOne
     */
    public function field(): HasOne
    {
        return $this->hasOne(Field::class, 'Id', 'FieldId');
    }
}
