<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uniforme extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'categoria', 'tipo'];

    public function fotos()
    {
        return $this->hasMany(UniformeFoto::class);
    }
}