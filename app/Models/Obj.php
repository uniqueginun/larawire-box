<?php

namespace App\Models;

use App\Traits\RelatedToTeam;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Obj extends Model
{
    use HasFactory, RelatedToTeam;

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

    /**
     * Get the owning objectable model.
     */
    public function objectable()
    {
        return $this->morphTo();
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

    /***
     * sub folders from the current obj
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }


    /***
     * the direct parent of the current obj
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function ancestors(): Collection
    {
        $ancestor = $this;

        $ancestors = collect();

        while ($ancestor->parent) {
            $ancestor = $ancestor->parent;
            $ancestors->push($ancestor);
        }

        $ancestors->push($this);

        return $ancestors->sortBy('id');
    }
}
