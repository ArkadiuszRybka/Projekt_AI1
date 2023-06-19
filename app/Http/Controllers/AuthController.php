<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }



    protected function login(Request $request)
    {
         $credentials = $request->only('email', 'password');

    // Zamiast używać domyślnej tablicy $users, sprawdzamy logowanie w bazie danych
    if (Auth::attempt($credentials)) {
        // Użytkownik został uwierzytelniony i zalogowany
        return redirect('main');
    } else {
        // Błędne dane logowania
        return back()->withErrors([
            'email' => 'Nieprawidłowy adres email lub hasło.',
        ]);
    }
    }

    protected function guard()
    {
        return auth()->guard(); // Domyślnie używany guard
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function register(Request $request)
    {
        try {
            $this->validator($request->all())->validate();

            $user = $this->create($request->all());

            return redirect()->route('main')->with('success', 'Rejestracja zakończona pomyślnie.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'city' => $data['city'],
            'password' => Hash::make($data['password']),
        ]);
    }


    public function showMeMain(){
        $cart = session()->get('cart', []);
        return view('main',['cart'=>$cart]);
    }
    public function showMeMain2(){
        $cart = session()->get('cart', []);
        return view('/',['cart'=>$cart]);
    }
}
