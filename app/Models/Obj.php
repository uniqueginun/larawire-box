<?php

namespace App\Models;

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

    /**
     * Get the owning objectable model.
     */
    public function objectable()
    {
        return $this->morphTo();
    }
}
