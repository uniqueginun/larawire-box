<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Obj extends Model
{
    use HasFactory;

    protected $table = 'objects';

    protected $fillable = [
        'parent_id'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($object) {
            $object->uuid = Str::uuid();
        });
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
     * Get the owning objectable model.
     */
    public function objectable()
    {
        return $this->morphTo();
    }

    public function scopeForTeam(Builder $builder, $teamId)
    {
        return $builder->where('team_id', $teamId);
    }

    public function scopeRoot(Builder $builder)
    {
        return $builder->whereNull('parent_id');
    }

    public function isFile()
    {
        return $this->objectable_type === "file";
    }

    public function isFolder()
    {
        return $this->objectable_type === "folder";
    }
}
