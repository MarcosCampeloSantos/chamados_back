<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interacoe extends Model
{
    use HasFactory;

    public function Anexos()
    {
        return $this->belongsToMany('App\Models\Anexo');
    }
}
