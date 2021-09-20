<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Record extends BaseModel
{
    /**
     * @return HasMany
     */
    public function values(): HasMany
    {
        return $this->hasMany(Value::class, 'RecordId', 'Id');
    }

    /**
     * @return HasOne
     */
    public function table(): HasOne
    {
        return $this->hasOne(Table::class, 'Id', 'TableId');
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'Id', 'UserId');
    }
}
