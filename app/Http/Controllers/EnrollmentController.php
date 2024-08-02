<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
class EnrollmentController extends Controller
{
    public function enrollment()
{

 

  
$viewPath = Auth::user()->user_type == 0
        ? 'superadmin.enrollment'
        : '' ;
    return view($viewPath
    );
}

}
