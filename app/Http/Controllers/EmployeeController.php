<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller {

    public function home() {
        $books = Book::has('user')->get();
        $users = User::where('verified', false)->get();
        return view('dashboard', [$books, $users]);
    }

    public function login(Request $request): RedirectResponse{
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::guard('admin')->attempt($credentials, true)) {
            Auth::login(Employee::where('email', $request->get("email"))->first());
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function create(Request $request) {
        $employee = $request->all();

        $rules = [
            'email' => 'required|max:255',
            'password' => 'required|max:255|min:5'
        ];
        $validator = Validator::make($employee, $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            try {
                DB::table('employees')->insert([
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password'))
                ]);
            } catch(\Exception $e) {
                return back()->withErrors(['email' => 'Compte existant']);
            }
        }
        return $employee;
    }

    public function verify(int $id) : RedirectResponse {
        if (Auth::guard('admin')->check()) {
            $user = User::where('id', $id)->firstOrFail();
            $user->verified = true;
            Auth::guard('admin')->$user->save();
            return back();
        }
        return redirect()->intended('dashboard');
    }

    public function restore(Request $request) : RedirectResponse {
        if (Auth::guard('admin')->check()) {
            $book = Book::where('id', $request->input('book_id'))->firstOrFail();
            $book->user()->dissociate();
            $book->save();
            $this->load('books');
            $this->load('users');
        }
        return redirect()->intended('/');
    }
}
