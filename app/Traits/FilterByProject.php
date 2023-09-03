<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterByProject
{
    public static function boot()
    {
        parent::boot();

        $currentProjectID = auth()->user()->current_project_id;

        self::creating(function ($model) use ($currentProjectID) {
            $model->project_id = $currentProjectID;
        });

        self::addGlobalScope(function (Builder $builder) use ($currentProjectID) {
            $builder->where('project_id', $currentProjectID);
        });
    }
}
