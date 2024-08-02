<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GraduateController extends Controller
{
    public function graduate()
    {
    
     
    
      
    $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.graduate'
            : '' ;
        return view($viewPath
        );
    }
}
