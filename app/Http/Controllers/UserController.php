<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {

    public function loginView() {
        return view('login');
    }

    public function registerForm() {
        return view('register');
    }

    public function create(Request $request) {
        $user = $request->all();

        $rules = [
            'email' => 'required|max:255',
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'password' => 'required|max:255|min:5',
            'address' => 'required'
        ];
        $validator = Validator::make($user, $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            DB::table('users')->insert([
                'email' => $request->input('email'),
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'password' => bcrypt($request->input('password')),
                'address' => $request->input('address')
            ]);
        }
        return redirect()->intended('/')
            ->with('message', 'Compte créé, veuillez attendre la validation d\'un de nos employés');
    }

    public function login(Request $request) : RedirectResponse {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        $user = User::where('email', $request->input('email'))->first();
        if (!is_null($user) && !$user->verified) {
            return back()->with('message', 'Utilisateur non vérifié');
        }
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/owned');
        }
        return back()->withErrors($credentials);
    }

    public function logout(Request $request) {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else {
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    public function borrow($id): RedirectResponse {
        if (Auth::check()) {
            $user = Auth::user();
            $book = Book::where('id', $id)->first();
            if (is_null($book)) {
                return back()->with('message', 'Livre non trouvé');
            }
            $user->books()->save($book);
            $book->confirmed = false;
            $book->save();
            return redirect()->intended('/books');
        }
        return redirect()->intended('/login');
    }

}
