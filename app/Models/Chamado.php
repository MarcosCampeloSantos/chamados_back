<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamado extends Model
{
    use HasFactory;

    public function pesquisa($filter)
    {   
        $query = Chamado::where(function($query) use ($filter){
            $query->where('title','LIKE', "%{$filter}%");
        })->paginate();

        return $query;
    }

    public function pesquisaFim($filter)
    {   
        $query = Chamado::where('title','LIKE', "%{$filter}%")->where('status_id', '2')->paginate();

        return $query;
    }
}
