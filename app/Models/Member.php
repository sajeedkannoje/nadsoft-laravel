<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create( mixed $validated )
 */
class Member extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    public function subMembers() : HasMany
    {
        return $this->hasMany(Member::class, 'parent_id', 'id');
    }
}
