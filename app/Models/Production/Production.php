<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Production extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'fillType', 'author', 'version', 'production', 'public_private', 'isMod'];

    protected $casts = ['production' => 'array', 'fillType' => 'array'];

    public function productionToMaps()
    {
        return $this->hasMany(ProductionToMap::class, 'production_id', 'id');
    }
}
