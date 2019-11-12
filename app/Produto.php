<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public function Categoria() 
    {
        return $this->belongsTo('App\Categoria');
    }
}
