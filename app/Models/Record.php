<?php

namespace App\Models;


use App\Constants\PostConstants;
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

    /**
     * @param $query
     * @return mixed
     */
    public function scopeByUser($query)
    {
        $user = auth()->user();
        switch ($user->Post) {
            case PostConstants::SUPER_ADMIN:
            case PostConstants::ADMIN:
            case PostConstants::MODERATOR:
            case PostConstants::RECTOR:
            case PostConstants::VICE_RECTOR:
                break;
            case PostConstants::DEAN:
            case PostConstants::VICE_DEAN:
                $query->whereIn('UserId', function ($q) use ($user) {
                    $q->select('Id')
                        ->from('users')
                        ->where('FacultyId', '=', $user->FacultyId);
                });
                break;
            case PostConstants::DEPARTMENT_HEAD:
                $query->whereIn('UserId', function ($q) use ($user) {
                    $q->select('Id')
                        ->from('users')
                        ->where('DepartmentId', '=', $user->DepartmentId);
                });
                break;
            default:
                $query->where('UserId', '=', $user->Id);
                break;
        }
        return $query;
    }

}
