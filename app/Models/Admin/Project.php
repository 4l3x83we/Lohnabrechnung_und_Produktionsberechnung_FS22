<?php

namespace App\Models\Admin;

use App\Models\Production\Production;
use App\Traits\FilterByTeam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use FilterByTeam;

    protected $fillable = [
        'team_id',
        'project_name',
        'project_image',
        'project_map',
    ];

    public function teams(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function productions()
    {
        $this->belongsToMany(Production::class, 'production_project');
    }
}
