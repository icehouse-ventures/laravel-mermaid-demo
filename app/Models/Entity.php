<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'parent_id',
    ];

    public function parent() {
        return $this->belongsTo(Entity::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Entity::class, 'parent_id');
    }
}
