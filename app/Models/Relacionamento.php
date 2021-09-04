<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relacionamento extends Model
{
    use HasFactory;

    public function topico()
    {
        return $this->hasMany(Topico::class);
    }

    public function departamento()
    {
        return $this->hasMany(Departamento::class);
    }

    public function atribuicoes()
    {
        return $this->hasMany(Atribuicoe::class);
    }
}
