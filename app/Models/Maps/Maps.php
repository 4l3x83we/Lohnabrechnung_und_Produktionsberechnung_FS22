<?php

namespace App\Models\Maps;

use App\Models\Production\Production;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maps extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'md_author',
        'md_version',
        'md_title_de',
        'md_title_en',
        'md_desc',
        'md_fillTypes',
        'md_fruitTypes',
        'md_farmlands',
        'md_sprayTypes',
        'md_fields',
        'md_sprayTypes_available',
        'team_id',
        'user_id',
        'md_public_private',
    ];

    protected $casts = [
        'md_title' => 'array',
        'md_desc' => 'array',
        'md_fillTypes' => 'array',
        'md_fruitTypes' => 'array',
        'md_farmlands' => 'array',
        'md_sprayTypes' => 'array',
        'md_fields' => 'array',
    ];

    public function productions()
    {
        $this->hasMany(Production::class);
    }
}
