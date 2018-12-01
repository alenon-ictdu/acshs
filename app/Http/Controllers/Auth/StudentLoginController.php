<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;

class StudentLoginController extends Controller
{
	public function __construct() {
		$this->middleware('guest:student', ['except' => ['studentLogout']]);
	}

    public function showLoginForm() {
        // under maintenance
        return redirect()->route('landing'); 

        if(Auth::guard('teacher')->check()){
            return redirect('/teacher'); 
        }
        elseif(Auth::guard('student')->check()){
            return redirect('/student'); 
        }
        elseif(Auth::guard()->check()){
            return redirect('/admin'); 
        }
        else {
            return view('students.login');
        }
        //return view('students.login');
    }

    public function login(Request $request) {
    	$this->validate($request, [
    		'id' => 'required',
    		'password' => 'required|min:6'
    	]);

    	if (Auth::guard('student')->attempt(['s_id' => $request->id, 'password' => $request->password], $request->remember)) {
    		return redirect()->route('student.sections');
    	} else {
            Session::flash('userNotFound', 'Invalid id/password');
        }

    	return redirect()->back()->withInput($request->only('id', 'remember'));
    }

    public function studentLogout() { 
        Auth::guard('student')->logout();

        return redirect()->route('student.login');
    }
}
