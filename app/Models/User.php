<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['Id'];

    protected $primaryKey = 'Id';

    public const CREATED_AT = 'CreatedAt';

    public const UPDATED_AT = 'UpdatedAt';

    public const DELETED_AT = 'DeletedAt';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'Password', 'RememberToken',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'EmailVerifiedAt' => 'datetime',
    ];

    public function faculty(): HasOne
    {
        return $this->hasOne(Faculty::class, 'Id', 'FacultyId');
    }

    public function department(): HasOne
    {
        return $this->hasOne(Department::class, 'Id', 'DepartmentId');
    }
}
