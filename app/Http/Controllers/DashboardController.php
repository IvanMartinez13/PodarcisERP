<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    function index (){
        $user = Auth::user();

        if ($user->hasRole('super-admin')) {
            $customers = Customer::get(); //get all customers
            $modules = Module::get(); //get all modules
            $size = filesize(storage_path('/app/public')); // Bytes;
            $maximo = 1073741824;
            $restante = ($maximo - $size) / $maximo;

            $length = strlen((string)$size); 

            if ($length >= 4 && $length < 8) { //KB
                $size = $size/1024 . " KB";
            }elseif($length >= 8 && $length < 12){//MB
                $size = $size/1048576 . " MB";
            }elseif($length >= 12){//GB
                $size = $size/1073741824 . " GB";
            }else{
                $size = $size . " Bytes";
            }
            

            return view('dashboard', compact('customers', 'modules', 'size', 'restante'));
        }

        return view('dashboard');
    }
}
