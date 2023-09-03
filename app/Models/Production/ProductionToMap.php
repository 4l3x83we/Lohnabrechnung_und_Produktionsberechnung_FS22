<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionToMap extends Model
{
    use SoftDeletes;

    protected $fillable = ['production_id', 'project_id'];

    public function productions()
    {
        return $this->belongsTo(Production::class, 'production_id', 'id');
    }
}
