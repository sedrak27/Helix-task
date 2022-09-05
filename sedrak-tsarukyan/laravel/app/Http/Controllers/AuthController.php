<?php

namespace App\Http\Controllers;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    public function register(){
        return view('register');
    }

    public function login(){
        return view('login');
    }

    public function userRegistration(Request $request) {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->verification_code = sha1(time());
        $response = $user->save();

        if($response){
            MailController::sendEmail(name:$user->name, email:$user->email,verificationCode: $user->verification_code);
            return back()->with(session()->flash('success', 'Check your email for verification'));
        }else{
            return back()->with(session()->flash('fail', 'Something went wrong try again'));
        }

    }

    public function userLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        $user = User::where('email', $request->email)->first();


        if($user){
            if(Hash::check($request->password, $user->password)){
                if($user->is_verified){
                    Session::put('userId', $user->id);
                    return redirect('user_dashboard');
                }else {
                    return back()->with('fail', 'Your account is not verified');
                }
            }else {
                return back()->with('fail', 'Password not matches try again');
            }
        }else{
            return back()->with('fail', 'This email is not registered');
        }
    }

    public function dashboard(){
        $userData = [];
        if(Session::has('userId')){
            $userData = User::where('id', Session::get('userId'))->first();
        }
        return view('dashboard', compact('userData',));
    }

    public function logout(){
        if(Session::has('userId')){
            Session::pull('userId');
            return redirect('login');
        }
    }

    public function verification(Request $request){
        $verificationCode = $request->get('code');
        $user = User::where('verification_code', $verificationCode)->first();

        if($user){
            $user->is_verified = true;
            $user->save();
            return redirect('/login')->with(session()->flash('success', 'Your account is verified'));
        }
        return back()->with(session()->flash('fail', 'Something went wrong try again. Invalid verification code!!!'));
    }
}
