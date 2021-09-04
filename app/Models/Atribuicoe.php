<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atribuicoe extends Model
{
    use HasFactory;

    public function relacionamento()
    {
        return $this->belongsTo(Relacionamento::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
