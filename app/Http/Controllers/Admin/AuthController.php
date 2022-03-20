<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {

    public function login(Request $request)
    {
        if ($request->ajax()){
            $data = $request->validate([
                'email'=>'required|exists:admins',
                'password'=>'required'
            ],[
                'email.required' => 'البريد الإلكترونى مطلوب',
                'email.exists' => 'البريد الإلكترونى غير موجود',
                'password.required' => 'كلمة المرور مطلوبة'
            ]);


            if (admin()->attempt($data)){
                return response()->json(200);
            }
            return response()->json(405);        }
        if (admin()->check())
            return redirect()->route('admin.index');

        return view('admin.auth.login');

    }//end fun
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        admin()->logout();

        toastr()->info('تم تسجيل الخروج');
        return redirect()->route('admin.login');

    }//end fun

}//end class
