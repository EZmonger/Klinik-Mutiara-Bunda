<?php

namespace App\Http\Controllers;

use App\Models\Nakes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{    
    public function signin(Request $request)
    {
        //VALIDATE
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        
        //CARI USERNAME
        $adminInfo = Nakes::where([
            'username' => strip_tags($request->username)
        ])->first();
        

        //CEK USERNAME DAN PROSES LOGIN
        if(!$adminInfo){
            //JIKA TIDAK ADA USERNAME
            return back()->with('fail', 'Username Tidak Ada!');
        }else{

            //CEK PASSWORD
            // $adminInfo->password == strip_tags($request->password)
            if (Hash::check($request->password, $adminInfo->password)) {
                
                //PROSES LOGIN MENGGUNAKAN SESSION
                $request->session()->put('loggedId', $adminInfo->id);
                $request->session()->put('loggedRole', $adminInfo->idRole);
                return redirect('/index');
                
            }else {
                //JIKA PASSWORD SALAH
                return back()->with('fail', 'Password salah!');
            }
        }
    }
}