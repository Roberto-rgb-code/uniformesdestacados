<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniformeFoto extends Model
{
    protected $fillable = ['uniforme_id', 'foto_path'];

    public function uniforme()
    {
        return $this->belongsTo(Uniforme::class);
    }
}