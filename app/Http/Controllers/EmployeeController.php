<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    //
    public function home(): String {
        return 'Yes la mif';
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
                // Return error
                return $e->getMessage();
            }
        }
        return $employee;
    }

    public function show($id) {
        $employee = DB::table('employee')->find($id);
    }
}
