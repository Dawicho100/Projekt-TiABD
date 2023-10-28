<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;



class UserController extends Controller
{
    //
    public function create(){
        return view('users.rejestracja');
    }
    public function store(Request $request) {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create User
        $user = User::create($formFields);

        // Login
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in');

    }
    public function logout(Request$request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    public function login(){
        return view('users.logowanie');
    }
    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);
        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect('/');
        }
        return  back()->withErrors(['email' => 'Zły email lub hasło'])->onlyInput('email');

    }
    public function showUsers()
    {
        $users = User::select('id', 'name', 'email', 'user_type', 'opis')->get();
        $message = "To jest wiadomość do wyświetlenia na stronie.";
        return view('panels.panel_admina.klienci', compact('users', 'message'));
    }
    public function updateDescription(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('usersindex')->with('error', 'Użytkownik nie istnieje.');
        }

        $user->opis = $request->opis;
        $user->save();

        return redirect()->route('usersindex')->with('success', 'Opis został zaktualizowany.');
    }







}
