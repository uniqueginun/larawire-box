<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'size',
        'path'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($file) {
            $file->uuid = Str::uuid();
        });
    }

    public function humanFileSize()
    {
        for($i = 0; ($this->size / 1024) > 0.9; $i++, $this->size /= 1024) {}
        return round($this->size, 2).['B','kB','MB','GB','TB','PB','EB','ZB','YB'][$i];
    }
}
