<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller {

    public function loginView() {
        return view('login');
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
            $user['password'] = bcrypt($request->input('password'));
            DB::table('users')->insert($user);
        }
        return $user;
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

            return redirect()->intended('/');
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
            $user_id = Auth::id();
            $user = User::where('id', $user_id)->first();
            $book = Book::where('id', $id)->first();
            if (is_null($user) || is_null($book)) {
                return back()->with('message', 'Livre ou utilisateur non trouvé');
            }
            $user->books()->save($book, ['borrowed_at', date("Y-m-d H:i:s")]);
            return redirect()->intended('/');
        }
        return redirect()->intended('login');
    }

}
