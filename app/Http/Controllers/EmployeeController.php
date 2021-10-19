<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller {

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->get('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/admin');
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
                DB::table('employee')->insert([
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password'))
                ]);
            } catch(\Exception $e) {
                return $e->getMessage();
            }
        }
        return $employee;
    }

    public function show($id) {
        $employee = DB::table('employee')->find($id);
        return view('showEmployee', $employee);
    }

    public function verify(int $id) {
        if (Auth::guard('admin')->check()) {
            $user = User::where('id', $id)->firstOrFail();
            $user->verified = true;
            Auth::guard('admin')->$user->save();
            return back();
        }
        return redirect()->intended('dashboard');
    }
}
