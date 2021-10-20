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

        if (Auth::attempt($credentials)) {
            if(User::where('email', $request->input('email'))->firstOrfail()->verified) {
                $request->session()->regenerate();

                return redirect()->intended('dashboard');
            }
            return redirect()->intended('unverified');
        }
        return back()->withErrors($credentials);
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function borrow($id): RedirectResponse {
        if (Auth::check()) {
            $user_id = Auth::id();
            $user = User::where('id', $user_id)->firstOrFail();
            $book = Book::where('id', $id)->firstOrFail();
            $user->books()->save($book, ['borrowed_at', date("Y-m-d H:i:s")]);
            return redirect()->intended('books');
        }
        return redirect()->intended('login');
    }

}
