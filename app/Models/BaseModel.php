<?php

namespace App\Models;

use App\Scopes\OrderByIdScope;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $guarded = ['Id'];

    protected $primaryKey = 'Id';

    public const CREATED_AT = 'CreatedAt';

    public const UPDATED_AT = 'UpdatedAt';

    public const DELETED_AT = 'DeletedAt';

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new OrderByIdScope);
    }
}
