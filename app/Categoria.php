<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public function Produto()
    {
        return $this->hasMany('App\Produto');
    }
}
