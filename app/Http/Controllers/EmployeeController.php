<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller {

    public function home() {
        $books = Book::has('user')->where('confirmed', true)->get();
        $users = User::where('verified', false)->get();
        return view('dashboard', [
            'books' => $books,
            'users' => $users
        ]);
    }

    public function confirm() {
        $books = Book::has('user')->where('confirmed', false)->get();
        return view('books.confirm', ['books' => $books]);
    }

    public function login(Request $request): RedirectResponse{
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::guard('admin')->attempt($credentials, true)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
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
            return back()->withErrors([
                'message' => 'Formulaire incorrect'
            ])->withInput();
        } else {
            try {
                DB::table('employees')->insert([
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password'))
                ]);
                Auth::guard('admin')->attempt([
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password'))
                ], true);
            } catch(\Exception $e) {
                return back()->withErrors(['message' => 'Compte existant']);
            }
        }
        return redirect()->intended('/admin/dashboard');
    }

    public function verify(int $id) : RedirectResponse {
        if (Auth::guard('admin')->check()) {
            $user = User::where('id', $id)->firstOrFail();
            $user->verified = true;
            $user->save();
        }
        return back();
    }

    public function restore(Request $request) : RedirectResponse {
        if (Auth::guard('admin')->check()) {
            $book = Book::where('id', $request->input('book_id'))->first();
            if (is_null($book)) {
                return redirect()->intended('/admin/dashboard');
            }
            $book->user()->dissociate();
            $book->borrowDate = null;
            $book->confirmed = null;
            $book->save();
            return redirect()->intended('/admin/dashboard');
        }
        return redirect()->intended('/admin/dashboard');
    }

    public function confirmBorrow($id): RedirectResponse {
        if (Auth::guard('admin')->check()) {
            $book = Book::where('id', $id)->first();
            if (is_null($book)) {
                return redirect()->intended('/admin/confirm');
            }
            $book->borrowDate = Carbon::now();
            $book->confirmed = true;
            $book->save();
        }
        return redirect()->intended('/admin/confirm');
    }
}
