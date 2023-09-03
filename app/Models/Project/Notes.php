<?php

namespace App\Models\Project;

use App\Traits\FilterByTeam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notes extends Model
{
    use FilterByTeam, SoftDeletes;

    protected $fillable = [
        'team_id',
        'project_id',
        'user_id',
        'text',
    ];
}
