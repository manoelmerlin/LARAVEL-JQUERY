<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioControlador extends Controller
{
    public function index() {
        return '<h3>Lista de usuários</h3>'.
            '<ul>' . 
                '<li>Joao</li>' .             
                '<li>Maria </li>' .             
                '<li>Jose</li>' .             
                '<li>Marcos</li>' .             
            '</ul>';
    }
}
