<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait RelatedToTeam
{

    public function scopeForCurrentTeam(Builder $builder)
    {
        return $builder->where('team_id', auth()->user()->currentTeam->id);
    }
}