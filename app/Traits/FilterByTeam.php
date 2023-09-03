<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterByTeam
{
    public static function boot()
    {
        parent::boot();

        $currentTeamID = auth()->user()->current_team_id;

        self::creating(function ($model) use ($currentTeamID) {
            $model->team_id = $currentTeamID;
        });

        self::addGlobalScope(function (Builder $builder) use ($currentTeamID) {
            $builder->where('team_id', $currentTeamID);
        });
    }
}
