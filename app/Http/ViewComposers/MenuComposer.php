<?php

namespace App\Http\ViewComposers;

use App\Models\Usuario;
use DB;
use Illuminate\Contracts\View\View;

class MenuComposer
{

    public function compose(View $view)
    {
        $tiposProcessos = Usuario::tiposDeProcesso();

        $view->with(compact('tiposProcessos'));
    }
}