<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Unit;
use App\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Menampilkan halaman registrasi pengguna untuk role 'User'
     */
    public function getregister(){

        // Dropdown Unit
        $units = Unit::all();

        return view('auth.register', compact('units'));
    }

    /**
     * Menyimpan data pengguna dengan role 'User' kedalam database
     */
    public function postregister(Request $request){

        $this->validate($request, [
            'employeeid'=>'required|unique:users|size:6',
            'unit_id' => 'required',
            'name' => 'required|max:191',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);
        
        $user = User::create([
            'employeeid' => $request->employeeid,
            'unit_id' => $request->unit_id,
            'role' => 'User',
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        Auth::loginUsingId($user->id);
        return redirect()->route('home');
    }

    /**
     * Menampilkan halaman registrasi pengguna untuk role 'Master'
     */
    public function getregistermaster(){

        // Dropdown Unit
        $units = Unit::all();

        return view('auth.registermaster', compact('units'));
    }

    /**
     * Menyimpan data pengguna dengan role 'Master' kedalam database
     */
    public function postregistermaster(Request $request){

        $this->validate($request, [
            'employeeid'=>'required|unique:users|size:6',
            'unit_id' => 'required',
            'name' => 'required|max:191',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);
        
        $user = User::create([
            'employeeid' => $request->employeeid,
            'unit_id' => $request->unit_id,
            'role' => 'Master',
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        Auth::loginUsingId($user->id);
        return redirect()->route('home');
    }

    /**
     * Menampilkan halaman login akun pengguna
     */
    public function getlogin(){
        
        return view('auth.login');
    }

    /**
     * Men-validasi dan autentifikasi data akun pengguna
     */
    public function postlogin(Request $request){

        $this->validate($request, [
            'employeeid'=>'required|size:6',
            'password' => 'required|min:6'
        ]);

        $rememberme = $request->has('rememberme') ? true : false;

        if(Auth::attempt($request->only('employeeid', 'password'), $rememberme)){
            return redirect()->route('home');
        }
            return redirect()->back()->with(['error' => 'Incorrect ID/Password']);
    }

    /**
     * Menampilkan halaman lupa password akun pengguna
     */
    public function getforgot(){
        
        return view('auth.forgotpassword');
    }

    /**
     * Autentifikasi logout dari akun pengguna
     */
    public function logout(){

        Auth::logout();
        return redirect()->back();
    }

}