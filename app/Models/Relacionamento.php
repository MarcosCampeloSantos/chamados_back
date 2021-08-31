<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relacionamento extends Model
{
    use HasFactory;

    public function topico()
    {
        return $this->belongsTo('App\Models\Topico');
    }

    public function departamento()
    {
        return $this->belongsTo('App\Models\Departamento');
    }
}
